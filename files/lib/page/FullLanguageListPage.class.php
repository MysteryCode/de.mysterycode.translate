<?php

namespace translate\page;
use wcf\page\SortablePage;
use wcf\system\WCF;

class FullLanguageListPage extends SortablePage {
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'countryCode';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = ['languageCode', 'countryCode', 'foreignLanguageName', 'languageName', 'i18nlanguageName'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = 'translate\\data\\language\\LanguageList';
	
	/**
	 * @see \wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'languageList';
	
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
			$this->objectList->getConditionBuilder()->add('countryCode = ?', [ $this->countryCode ]);
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
