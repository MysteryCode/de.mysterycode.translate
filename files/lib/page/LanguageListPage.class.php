<?php

namespace translate\page;
use translate\data\language\LanguageCache;
use translate\data\language\LanguageList;
use wcf\page\SortablePage;
use wcf\system\WCF;

class LanguageListPage extends SortablePage {
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'countryCode';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = ['languageID', 'languageCode', 'countryCode', 'foreignLanguageName', 'languageName', 'i18nlanguageName'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = LanguageList::class;
	
	/**
	 * filter for languages of a specific country
	 * @var string
	 */
	public $countryCode = '';
	
	/**
	 * @see \wcf\page\SortablePage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['countryCode'])) $this->countryCode = $_REQUEST['countryCode'];
	}
	
	/**
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	public function initObjectList() {
		parent::initObjectList();
		
		if (!empty($this->countryCode)) {
			$this->objectList->getConditionBuilder()->add('language.countryCode = ?', [ $this->countryCode ]);
		}
		
		if (WCF::getUser()->userID) {
			$this->objectList->getConditionBuilder()->add('language.languageID IN (?)', [ LanguageCache::getInstance()->getAccessibleLanguageIDs() ]);
		}
	}
	
	/**
	 * @see \wcf\page\SortablePage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'countryCode' => $this->countryCode
		]);
	}
}
