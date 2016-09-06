<?php

namespace translate\page;
use translate\data\language\item\LanguageItemList;
use wcf\page\SortablePage;
use wcf\system\WCF;
use translate\data\language\LanguageCache;

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
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	public function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->sqlOrderBy .= ' GROUP BY language_item.languageItem';
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'availableLanguages' => LanguageCache::getInstance()->getLanguages()
		]);
	}
}
