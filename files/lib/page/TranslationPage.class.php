<?php

namespace translate\page;
use translate\data\language\item\LanguageItemList;
use translate\data\language\Language;
use translate\data\language\LanguageCache;
use translate\data\package\Package;
use translate\data\package\PackageCache;
use wcf\page\SortablePage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class TranslationPage extends SortablePage {
	/**
	 * class name for DatabaseObjectList
	 * @var	string
	 */
	public $objectListClassName = LanguageItemList::class;
	
	/**
	 * selected sort field
	 * @var	string
	 */
	public $sortField = 'languageCategoryID';
	
	/**
	 * selected sort order
	 * @var	string
	 */
	public $sortOrder = 'ASC';
	
	/**
	 * @inheritDoc
	 */
	public $sqlLimit = 20;
	
	/**
	 * id of the package whichs language items
	 * should be translated
	 * 
	 * @var integer
	 */
	public $packageID = 0;
	
	/**
	 * package object
	 * 
	 * @var Package
	 */
	public $package = null;
	
	/**
	 * id of the language the language items
	 * should be translated into
	 * 
	 * @var integer
	 */
	public $languageID = 0;
	
	/**
	 * target language object
	 * 
	 * @var Language
	 */
	public $language = null;
	
	/**
	 * source language object
	 * 
	 * @var Language
	 */
	public $sourceLanguage = null;
	
	/**
	 * source secondary language object
	 * 
	 * @var Language
	 */
	public $secondarySourceLanguage = null;
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['packageID'])) $this->packageID = $_REQUEST['packageID'];
		$this->package = PackageCache::getInstance()->getPackage($this->packageID);
		if ($this->package === null)
			throw new IllegalLinkException();
		
		if (isset($_REQUEST['languageID'])) $this->languageID = $_REQUEST['languageID'];
		$this->language = LanguageCache::getInstance()->getLanguage($this->languageID);
		if ($this->language === null)
			throw new IllegalLinkException();
	}
	
	/**
	 * @inheritDoc
	 */
	public function readData() {
		parent::readData();
		
		if (WCF::getUser()->getUserOption('originLanguage'))
			$this->sourceLanguage = LanguageCache::getInstance()->getLanguageByCode(WCF::getUser()->getUserOption('originLanguage'));
		else
			$this->sourceLanguage = LanguageCache::getInstance()->getLanguageByCode(WCF::getLanguage()->languageCode);
		
		if (WCF::getUser()->getUserOption('originLanguageSecondary'))
			$this->secondarySourceLanguage = LanguageCache::getInstance()->getLanguageByCode(WCF::getUser()->getUserOption('originLanguageSecondary'));
	}
	
	/**
	 * @inheritDoc
	 */
	public function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->getConditionBuilder()->add('language_item.packageID = ?', [ $this->packageID ]);
		
		// get only language items with value in source language or secondary source language
		$this->objectList->getConditionBuilder()->add('language_item.languageItemID IN (
			SELECT	language_item_value.languageItemID
			FROM	translate' . WCF_N . '_language_item_value language_item_value
			WHERE	language_item_value.languageID IN (?)
				AND language_item_value.languageItemID = language_item.languageItemID
		)', [ $this->sourceLanguage->languageID, (($this->secondarySourceLanguage !== null) ? $this->secondarySourceLanguage->languageID : 0) ]);
		
		// don't get already translated items
		$this->objectList->getConditionBuilder()->add('language_item.languageItemID NOT IN (
			SELECT	language_item_value.languageItemID
			FROM	translate' . WCF_N . '_language_item_value language_item_value
			WHERE	language_item_value.languageID = ?
				AND language_item_value.languageItemID = language_item.languageItemID
		)', [ $this->languageID ]);
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'targetLanguage' => $this->language,
			'package' => $this->package,
			'sourceLanguage' => $this->language,
			'secondarySourceLanguage' => $this->secondarySourceLanguage
		]);
	}
}
