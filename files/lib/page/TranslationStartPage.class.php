<?php

namespace translate\page;
use translate\data\language\LanguageCache;
use translate\data\package\PackageList;
use wcf\page\AbstractPage;
use wcf\system\WCF;

class TranslationStartPage extends AbstractPage {
	public $packageList = null;
	
	/**
	 * @inheritDoc
	 */
	public function readData() {
		parent::readData();
		
		// languages the user can translate into
		$accessibleLanguageIDs = LanguageCache::getInstance()->getAccessibleLanguageIDs() ?: [];
		
		// languages the user wants to translate from
		$sourceLanguages[] = LanguageCache::getInstance()->getLanguageByCode(WCF::getUser()->getUserOption('originLanguage'))->languageID;
		if (WCF::getUser()->getUserOption('originLanguageSecondary'))
			$sourceLanguages[] = LanguageCache::getInstance()->getLanguageByCode(WCF::getUser()->getUserOption('originLanguageSecondary'))->languageID;
		
		$this->packageList = new PackageList();
		
		// packages with at least 1 language item
		$this->packageList->getConditionBuilder()->add('package.variables > ?', [ 0 ]);
		
		// packages with language items which are not translated into all not excluded languages
		$this->packageList->getConditionBuilder()->add('package.packageID IN (
			SELECT	language_item.packageID
			FROM	translate' . WCF_N . '_language_item language_item
			WHERE ? > (
				SELECT	COUNT(language_item_value.languageItemID)
				FROM	translate' . WCF_N . '_language_item_value language_item_value
				WHERE	language_item_value.languageID IN (?)
					AND language_item_value.languageItemID = language_item.languageItemID
			)
				AND package.packageID = language_item.packageID
		)', [ count($accessibleLanguageIDs), $accessibleLanguageIDs ]);
		
		// packages with language items which have language items in source language
		$this->packageList->getConditionBuilder()->add('package.packageID IN (
			SELECT	language_item.packageID
			FROM	translate' . WCF_N . '_language_item language_item
			WHERE language_item.languageItemID IN (
				SELECT	language_item_value.languageItemID
				FROM	translate' . WCF_N . '_language_item_value language_item_value
				WHERE	language_item_value.languageID IN (?)
					AND language_item_value.languageItemID = language_item.languageItemID
			)
				AND package.packageID = language_item.packageID
		)', [ $sourceLanguages ]);
		
		$this->packageList->readObjects();
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'packageList' => $this->packageList
		]);
	}
}
