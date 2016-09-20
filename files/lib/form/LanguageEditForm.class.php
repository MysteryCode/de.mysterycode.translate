<?php

namespace translate\form;
use translate\data\language\Language;
use translate\data\language\LanguageAction;
use wcf\data\package\PackageCache;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\language\I18nHandler;
use wcf\system\WCF;

class LanguageEditForm extends LanguageAddForm {
	/**
	 * language id
	 * @var	integer
	 */
	public $languageID = 0;
	
	/**
	 * @inheritDoc
	 */
	public $action = 'edit';
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->languageID = intval($_REQUEST['id']);
		$this->language = new Language($this->languageID);
		if (!$this->language->languageID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		$languageData = [ 'data' => [
				'languageName' => $this->languageName,
				'languageCode' => mb_strtolower($this->languageCode),
				'countryCode' => mb_strtolower($this->countryCode),
				'foreignLanguageName' => $this->foreignLanguageName
			]
		];
		$this->objectAction = new LanguageAction([ $this->language ], 'update', $languageData);
		$this->objectAction->executeAction();
		
		// save i18n values
		$this->saveI18nValue($this->language, 'languageName');
		
		$this->saved();
		
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			// get i18n values
			I18nHandler::getInstance()->setOptions('languageName', PackageCache::getInstance()->getPackageID('de.mysterycode.translate'), $this->language->languageName, 'translate.language.language\d+');
			
			$this->countryCode = $this->language->countryCode;
			//$this->languageName = $this->language->languageName;
			$this->foreignLanguageName = $this->language->foreignLanguageName;
			$this->languageCode = $this->language->languageCode;
		}
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'languageID' => $this->languageID,
			'language' => $this->language,
		]);
	}
}
