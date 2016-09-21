<?php

namespace translate\page;
use translate\data\language\LanguageCache;
use translate\data\package\PackageList;
use wcf\page\AbstractPage;
use wcf\system\WCF;

class TranslationStartPage extends AbstractPage {
	public $packageList = null;
	
	public $languageList = null;
	
	/**
	 * @inheritDoc
	 */
	public function readData() {
		parent::readData();
		
		$this->languageList = LanguageCache::getInstance()->getAccessibleLanguages();
		$this->packageList = new PackageList();
		$this->packageList->readObjects();
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'availableLanguages' => $this->languageList,
			'packageList' => $this->packageList
		]);
	}
}
