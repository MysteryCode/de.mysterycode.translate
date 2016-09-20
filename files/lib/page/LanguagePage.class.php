<?php

namespace translate\page;
use translate\data\language\LanguageCache;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class LanguagePage extends AbstractPage {
	public $languageID = 0;
	
	public $language = null;
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->languageID = $_REQUEST['id'];
		
		$this->language = LanguageCache::getInstance()->getLanguage($this->languageID);
		if ($this->language === null)
			throw new IllegalLinkException();
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'language' => $this->language
		]);
	}
}
