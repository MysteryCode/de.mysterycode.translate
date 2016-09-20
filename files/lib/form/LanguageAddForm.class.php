<?php

namespace translate\form;
use translate\data\language\Language;
use translate\data\language\LanguageAction;
use translate\data\language\LanguageCache;
use translate\data\language\LanguageEditor;
use translate\data\language\LanguageList;
use translate\data\package\PackageEditor;
use wcf\acp\form\LanguageAddForm as ACPLanguageAddForm;
use wcf\data\language\LanguageEditor as WCFLanguageEditor;
use wcf\data\package\PackageCache;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\language\I18nHandler;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;
use wcf\util\StringUtil;

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
	 * @inheritDoc
	 */
	public $templateNameApplication = 'translate';
	
	/**
	 * @inheritDoc
	 */
	public $action = 'add';
	
	public function readParameters() {
		parent::readParameters();
		
		// initiate i18n handler
		I18nHandler::getInstance()->register('languageName');
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		I18nHandler::getInstance()->readValues();
		if (I18nHandler::getInstance()->isPlainValue('languageName')) $this->languageName = I18nHandler::getInstance()->getValue('languageName');
		if (isset($_POST['foreignLanguageName'])) $this->foreignLanguageName = StringUtil::trim($_POST['foreignLanguageName']);
	}
	
	/**
	 * @inheritDoc
	 */
	public function validate() {
		AbstractForm::validate();
		
		// country code
		if (empty($this->countryCode))
			throw new UserInputException('countryCode');
		
		// language code
		$this->validateLanguageCode();
		
		// source language id
		$this->validateSource();
		
		// foreign language name
		if (empty($this->foreignLanguageName))
			throw new UserInputException('foreignLanguageName');
		
		// Validate language name
		if (!I18nHandler::getInstance()->validateValue('languageName')) {
			if (I18nHandler::getInstance()->isPlainValue('languageName')) {
				throw new UserInputException('languageName');
			} else {
				throw new UserInputException('languageName', 'multilingual');
			}
		}
	}
	
	/**
	 * @see \wcf\acp\form\LanguageAddForm::validateSource()
	 */
	protected function validateSource() {
		if (!empty($this->sourceLanguage)) {
			// get language
			$this->sourceLanguage = new Language($this->sourceLanguageID);
			if (!$this->sourceLanguage->languageID) {
				throw new UserInputException('sourceLanguageID');
			}
		}
	}
	
	/**
	 * Validates the language code.
	 */
	protected function validateLanguageCode() {
		if (empty($this->languageCode)) {
			throw new UserInputException('languageCode');
		}
		if (LanguageCache::getInstance()->getLanguageByCode($this->languageCode)) {
			throw new UserInputException('languageCode', 'notUnique');
		}
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		$languageData = [ 'data' => [
				'languageName' => $this->foreignLanguageName,
				'languageCode' => mb_strtolower($this->languageCode),
				'countryCode' => mb_strtolower($this->countryCode),
				'foreignLanguageName' => $this->foreignLanguageName
			]
		];
		$this->objectAction = new LanguageAction([], 'create', $languageData);
		$returnValues = $this->objectAction->executeAction();
		
		// save i18n values
		$this->saveI18nValue($returnValues['returnValues'], 'languageName');
		
		if (LanguageFactory::getInstance()->getLanguageByCode($this->languageCode) === null) {
			$newLanguage = WCFLanguageEditor::create([
				'countryCode' => mb_strtolower($this->countryCode),
				'languageName' => $this->foreignLanguageName,
				'languageCode' => mb_strtolower($this->languageCode)
			]);
			if ($this->sourceLanguage !== null) {
				$languageEditor = new WCFLanguageEditor($this->sourceLanguage->getSystemLanguage());
				$languageEditor->copy($newLanguage);
			}
			
			LanguageFactory::getInstance()->clearCache();
			LanguageFactory::getInstance()->deleteLanguageCache();
		}
		
		LanguageEditor::resetCache();
		PackageEditor::resetCache();
		
		$this->saved();
		
		// reset
		I18nHandler::getInstance()->reset();
		
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
		
		// assign i18n values
		I18nHandler::getInstance()->assignVariables();
		
		WCF::getTPL()->assign([
			'foreignLanguageName' => $this->foreignLanguageName,
			'languages' => $this->languages,
			'action' => $this->action
		]);
	}
	
	/**
	 * @param Language $language
	 * @param String $columnName
	 */
	public function saveI18nValue(Language $language, $columnName) {
		$values = I18nHandler::getInstance()->getValues('languageName');
		foreach ($values as $key => $value) {
			if (empty($values[$key]))
				$values[$key] = $this->foreignLanguageName;
		}
		I18nHandler::getInstance()->setValues('languageName', $values);
		
		if (!I18nHandler::getInstance()->isPlainValue($columnName)) {
			I18nHandler::getInstance()->save($columnName, 'translate.language.language' . $language->languageID, 'translate.language', PackageCache::getInstance()->getPackageID('de.mysterycode.translate'));
			
			$languageEditor = new LanguageEditor($language);
			$languageEditor->update(array(
				$columnName => 'translate.language.language' . $language->languageID
			));
		}
	}
}
