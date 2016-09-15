<?php

namespace translate\page;
use translate\data\package\PackageList;
use wcf\page\SortablePage;
use wcf\system\WCF;

class PackageListPage extends SortablePage {
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'i18ntitle';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = ['packageID', 'title', 'identifier', 'author', 'variables', 'checkedVariables', 'i18ntitle'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = PackageList::class;
	
// 	public function initObjectList() {
// 		parent::initObjectList();
		
// 		$this->objectList->sqlSelects .= "IF ( wcf_language_item.languageItemValue = '' OR wcf_language_item.languageItemValue IS NULL, package.title, wcf_language_item.languageItemValue ) AS i18Title";
// 		$this->objectList->sqlJoins .= "LEFT JOIN wcf" . WCF_N . "_language_item wcf_language_item ON wcf_language_item.languageItem = package.title AND wcf_language_item.languageID = " . WCF::getLanguage()->languageID;
// 	}
}
