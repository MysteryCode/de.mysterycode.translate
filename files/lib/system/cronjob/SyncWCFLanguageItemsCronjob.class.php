<?php

namespace translate\system\cronjob;
use translate\data\language\category\LanguageCategory;
use translate\data\language\category\LanguageCategoryAction;
use translate\data\language\category\LanguageCategoryCache;
use translate\data\language\item\value\LanguageItemValue;
use translate\data\language\item\value\LanguageItemValueAction;
use translate\data\language\item\value\LanguageItemValueEditor;
use translate\data\language\item\LanguageItem;
use translate\data\language\item\LanguageItemAction;
use translate\data\language\item\LanguageItemCache;
use translate\data\language\item\LanguageItemList;
use translate\data\language\LanguageCache;
use translate\data\package\PackageCache;
use translate\util\LanguageFileReaderUtil;
use wcf\data\cronjob\Cronjob;
use wcf\system\cronjob\AbstractCronjob;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

class SyncWCFLanguageItemsCronjob extends AbstractCronjob {

	public function execute (Cronjob $cronjob) {
		parent::execute($cronjob);
		
		$langItemList = new LanguageItemList();
		$langItemList->getConditionBuilder()->add('language_item.packageID IN (?)', [
			[
				PackageCache::getInstance()->getPackageIDByIdentifier('com.woltlab.wcf'),
				PackageCache::getInstance()->getPackageIDByIdentifier('de.mysterycode.translate')
			]
		]);
		$langItemList->readObjects();
		
		$existingItems = [];
		
		/** @var $langItem \translate\data\language\item\LanguageItem */
		foreach ($langItemList->getObjects() as $langItem) {
			$values = $langItem->getTranslations();
			
			foreach ([
				'de',
				'en'
			] as $langCode) {
				$languageID = LanguageCache::getInstance()->getLanguageIDByCode($langCode);
				$wcfLanguageID = LanguageFactory::getInstance()->getLanguageByCode($langCode);
				
				if (! empty($values[$languageID])) {
					$existingItems[$languageID][$langItem->languageItem] = $values[$languageID];
				}
			}
			
			unset($values);
		}
		
		// yep, it's a specific path
		$folder = str_replace('translate.mysterycode.de', '', WCF_DIR) . 'git/wcf-next/wcfsetup/install/lang/';
		foreach ([
			'de',
			'en'
		] as $languageCode) {
			$content = file_get_contents($folder . $languageCode . '.xml');
			$structure = LanguageFileReaderUtil::parseXML($content);
			$language = LanguageCache::getInstance()->getLanguageByCode($languageCode);
			
			foreach ($structure as $categoryName => $languageItems) {
				/** @var $category \translate\data\language\category\LanguageCategory */
				$category = LanguageCategoryCache::getInstance()->getLanguageCategoryByName($categoryName);
				
				if ($category === null) {
					$category = LanguageCategory::getLanguageCategoryByName($categoryName);
					
					if ($category === null) {
						$categoryAction = new LanguageCategoryAction([], 'create', [
							'data' => [
								'languageCategory' => $categoryName
							]
						]);
						$result = $categoryAction->executeAction();
						$category = $result['returnValues'];
					}
				}
				
				foreach ($languageItems as $languageItem => $languageItemValue) {
					if (empty($languageItemValue)) continue;
					
					if (! isset($existingItems[$language->languageID][$languageItem])) {
						$languageItemObject = LanguageItem::getLanguageItemByIdentifier($languageItem);
						
						if (!$languageItemObject->languageItemID) {
							$languageItemAction = new LanguageItemAction([], 'create', [
								'data' => [
									'languageItem' => $languageItem,
									'packageID' => PackageCache::getInstance()->getPackageIDByIdentifier('com.woltlab.wcf'),
									'languageCategoryID' => $category->languageCategoryID
								]
							]);
							$itemResult = $languageItemAction->executeAction();
							$languageItemObject = $itemResult['returnValues'];
						}
					}
					else {
						$languageItemObject = LanguageItemCache::getInstance()->getLanguageItemIDByIdentifier($languageItem);
					}
					
					if (empty($existingItems[$language->languageID][$languageItem])) {
						$languageItemValueAction = new LanguageItemValueAction([], 'create', [
							'data' => [
								'languageID' => $language->languageID,
								'languageItemID' => $languageItemObject->languageItemID,
								'languageItemValue' => $languageItemValue,
								'checked' => 1
							]
						]);
						continue;
					}
					
					if ($existingItems[$language->languageID][$languageItem] != $languageItemValue) {
						$sql = "SELECT language_item_value.*
							FROM translate" . WCF_N . "_language_item_value language_item_value
							WHERE language_item_value.languageItemID = ?
								AND language_item_value.languageID = ?";
						$statement = WCF::getDB()->prepareStatement($sql);
						$statement->execute([
							$languageItemObject->languageItemID,
							$language->languageID
						]);
						$row = $statement->fetchArray();
						
						$languageItemValueEditor = new LanguageItemValueEditor(new LanguageItemValue(null, $row));
						$languageItemValueEditor->update([
							'languageItemValue' => $languageItemValue
						]);
						
						unset($row);
					}
					
					unset($itemResult);
				}
			}
			
			unset($content, $structure);
		}
	}
}
