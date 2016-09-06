<?php

namespace translate\page;
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
	public $validSortFields = ['languageCode', 'countryCode', 'foreignLanguageName', 'languageName'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = 'translate\\data\\language\\LanguageList';
	
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
			$this->objectList->getConditionBuilder()->add('countryCode = ?', array($this->countryCode));
		}
		
		if (WCF::getUser()->userID) {
			$excludedLanguages = WCF::getUser()->getUserOption('translateExcludedLanguages');
			if (!empty($excludedLanguages)) {
				$this->objectList->getConditionBuilder()->add('languageCode NOT IN (?)', array($excludedLanguages));
			}
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