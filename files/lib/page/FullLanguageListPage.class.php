<?php

namespace translate\page;
use wcf\page\SortablePage;
use wcf\system\WCF;

class FullLanguageListPage extends LanguageListPage {
	/**
	 * @see \wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'languageList';
	
	/**
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	public function initObjectList() {
		SortablePage::initObjectList();
		
		if (!empty($this->countryCode)) {
			$this->objectList->getConditionBuilder()->add('countryCode = ?', [ $this->countryCode ]);
		}
	}
}
