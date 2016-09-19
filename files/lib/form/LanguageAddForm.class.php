<?php

namespace translate\form;
use translate\data\language\Language;
use translate\data\language\LanguageAction;
use translate\data\language\LanguageList;
use wcf\acp\form\LanguageAddForm as ACPLanguageAddForm;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

class LanguageAddForm extends ACPLanguageAddForm {
	/**
	 * @see \wcf\acp\form\AbstractForm::$activeMenuItem
	 */
	public $activeMenuItem = 'translate.menu.link.language';
	
	/**
	 * @see \wcf\acp\form\AbstractForm::$neededPermissions
	 */
	public $neededPermissions = [];
	
	/**
	 * language object
	 * @var	\translate\data\language\Language
	 */
	public $language = null;
	
	/**
	 * foreign language name
	 * @var	string
	 */
	public $foreignLanguageName = '';
	
	/**
	 * source language object
	 * @var	\translate\data\language\Language
	 */
	public $sourceLanguage = null;
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['foreignLanguageName'])) $this->foreignLanguageName = StringUtil::trim($_POST['foreignLanguageName']);
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->foreignLanguageName))
			throw new UserInputException('foreignLanguageName');
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::validateSource()
	 */
	protected function validateSource() {
		if (empty($this->sourceLanguageID)) {
			throw new UserInputException('sourceLanguageID');
		}
		
		// get language
		$this->sourceLanguage = new Language($this->sourceLanguageID);
		if (!$this->sourceLanguage->languageID) {
			throw new UserInputException('sourceLanguageID');
		}
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		$languageData = [
			'languageName' => $this->languageName,
			'languageCode' => mb_strtolower($this->languageCode),
			'countryCode' => mb_strtolower($this->countryCode),
			'foreignLanguageName' => $this->foreignLanguageName,
			'sourceLanguageID' => $this->sourceLanguageID
		];
		$languageAction = new LanguageAction([], 'create', $languageData);
		$languageAction->executeAction();
		
		$this->language = LanguageEditor::create([
			'countryCode' => mb_strtolower($this->countryCode),
			'languageName' => $this->foreignLanguageName,
			'languageCode' => mb_strtolower($this->languageCode)
		]);
		$languageEditor = new LanguageEditor($this->sourceLanguage->getSystemLanguage());
		$languageEditor->copy($this->language);
		
		LanguageFactory::getInstance()->clearCache();
		LanguageFactory::getInstance()->deleteLanguageCache();
		
		$this->saved();
		
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::readData()
	 */
	public function readData() {
		AbstractForm::readData();
		
		$languageList = new LanguageList();
		$languageList->readObjects();
		$this->languages = $languageList->getObjects();
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'foreignLanguageName' => $this->foreignLanguageName,
			'languages' => $this->languages
		]);
	}
}
