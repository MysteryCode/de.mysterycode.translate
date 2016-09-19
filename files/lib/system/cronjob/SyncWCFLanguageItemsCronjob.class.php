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
use translate\data\language\item\LanguageItemEditor;
use translate\data\language\item\LanguageItemList;
use translate\data\language\LanguageCache;
use translate\data\language\LanguageEditor;
use translate\data\package\PackageCache;
use translate\data\package\PackageEditor;
use translate\util\LanguageFileReaderUtil;
use wcf\data\cronjob\Cronjob;
use wcf\system\cronjob\AbstractCronjob;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

class SyncWCFLanguageItemsCronjob extends AbstractCronjob {

	public $languageFileFolder = '';

	public $packageName = 'com.woltlab.wcf';

	public function execute (Cronjob $cronjob) {
		parent::execute($cronjob);
		
		$this->fixFolderPath();
		
		$langItemList = new LanguageItemList();
		$langItemList->getConditionBuilder()->add('language_item.packageID = ?', [
			PackageCache::getInstance()->getPackageIDByIdentifier($this->packageName)
		]);
		$langItemList->readObjects();
		
		$existingItems = [];
		
		/** @var $langItem \translate\data\language\item\LanguageItem */
		foreach ($langItemList->getObjects() as $langItem) {
			$values = $langItem->getTranslations();
			
			foreach ([
				'de',
				'de-informal',
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
		
		foreach ([
			'de',
			'en'
		] as $languageCode) {
			if (!file_exists($this->languageFileFolder . $languageCode . '.xml'))
				continue;
			
			$content = file_get_contents($this->languageFileFolder . $languageCode . '.xml');
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
						
						if ($languageItemObject == null || ! $languageItemObject->languageItemID) {
							$languageItemAction = new LanguageItemAction([], 'create', [
								'data' => [
									'languageItem' => $languageItem,
									'packageID' => PackageCache::getInstance()->getPackageIDByIdentifier($this->packageName),
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
						$languageItemValueAction->executeAction();
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
		
		// reset caches
		LanguageItemEditor::resetCache();
		LanguageEditor::resetCache();
		PackageEditor::resetCache();
	}

	protected function fixFolderPath () {
		// yep, it's a specific path
		$this->languageFileFolder = str_replace('translate.mysterycode.de', '', WCF_DIR) . 'git/wcf-next/wcfsetup/install/lang/';
	}
}
