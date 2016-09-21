<?php

namespace translate\page;
use translate\data\language\item\LanguageItemList;
use translate\data\language\LanguageCache;
use translate\data\package\PackageCache;
use wcf\page\SortablePage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class LanguageItemListPage extends SortablePage {
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'languageItem';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = ['languageItemID', 'languageItem', 'languageCategoryID'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = LanguageItemList::class;
	
	/**
	 * id of a Package whichs items should be listed
	 * @var integer
	 */
	public $packageID = 0;
	
	/**
	 * id of a Language whichs items should be listed
	 * @var integer
	 */
	public $languageID = 0;
	
	/**
	 * {@inheritDoc}
	 */
	public function readParameters() {
		parent::readParameters();

		if (!empty($_REQUEST['packageID'])) {
			$this->packageID = intval($_REQUEST['packageID']);
			$package = PackageCache::getInstance()->getPackage($this->packageID);
			if ($package === null)
				throw new IllegalLinkException();
		}
		
		if (!empty($_REQUEST['languageID'])){
			$this->languageID = intval($_REQUEST['languageID']);
			$language = LanguageCache::getInstance()->getLanguage($this->languageID);
			if ($language === null)
				throw new IllegalLinkException();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->sqlOrderBy .= ' GROUP BY language_item.languageItem';
		
		if ($this->packageID) {
			$this->objectList->getConditionBuilder()->add('language_item.packageID = ?', [ $this->packageID ]);
		}
		
		if ($this->languageID) {
			$this->objectList->sqlSelects .= "language_item_value.languageID";
			$this->objectList->sqlJoins = $this->objectList->sqlConditionJoins .= " INNER JOIN translate" . WCF_N . "_language_item_value language_item_value ON language_item.languageItemID = language_item_value.languageItemID";
			$this->objectList->getConditionBuilder()->add('language_item_value.languageID = ?', [ $this->languageID ]);
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'availableLanguages' => LanguageCache::getInstance()->getLanguages(),
			'packageID' => $this->packageID,
			'languageID' => $this->languageID
		]);
	}
}
