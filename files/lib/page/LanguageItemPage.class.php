<?php

namespace translate\page;
use translate\data\language\item\LanguageItemCache;
use wcf\page\AbstractPage;
use wcf\system\WCF;

class LanguageItemPage extends AbstractPage {
	public $languageItemID = 0;
	
	public $languageItem = null;
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->languageItemID = $_REQUEST['id'];
		
		$this->languageItem = LanguageItemCache::getInstance()->getLanguageItem($this->languageItemID);
		if ($this->languageItem === null)
			throw new IllegalLinkException();
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'languageItem' => $this->languageItem
		]);
	}
}
