<?php

namespace translate\data\language;
use wcf\data\DatabaseObject;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

/**
 * @property-read	integer		$languageID		unique id of the language
 * @property-read	string		$languageCode		code of the language according to ISO 639-1
 * @property-read	string		$languageName		name of the language (i18n)
 * @property-read	string		$foreignLanguageName		name of the language within the language itself
 * @property-read	string		$countryCode		code of the country using the language according to ISO 3166-1, used to determine the language's country flag
 * @property-read	integer		$isDisabled		is `1` if the language is disabled and thus not selectable, otherwise `0`
 */
class Language extends DatabaseObject {
	/**
	 * Returns the language name in the user's language
	 * 
	 * @return string
	 */
	public function getTitle() {
		return  WCF::getLanguage()->get($this->languageName);
	}
	
	/**
	 * Returns the language object of the WCF's language management
	 * based on a languageCode-matching
	 * 
	 * @return \wcf\data\language\Language
	 */
	public function getSystemLanguage() {
		return LanguageFactory::getInstance()->getLanguageByCode($this->languageCode);
	}
	
	/**
	 * Returns the fixed language code of this language.
	 *
	 * @return	string
	 */
	public function getFixedLanguageCode() {
		return LanguageFactory::fixLanguageCode($this->languageCode);
	}
	
	/**
	 * Returns language icon path.
	 *
	 * @return	string
	 */
	public function getIconPath() {
		return WCF::getPath() . 'icon/flag/'.$this->countryCode.'.svg';
	}
	
	/**
	 * Returns the image-tag for the country icon
	 * 
	 * @return string
	 */
	public function getIconTag() {
		return '<img class="languageIcon jsTooltip" src="' . $this->getIconPath() . '" title="' . $this->getTitle() . '" alt="' . $this->getTitle() . '" />';
	}
}
