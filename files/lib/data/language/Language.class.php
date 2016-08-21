<?php

namespace translate\data\language;
use wcf\data\DatabaseObject;
use wcf\system\language\LanguageFactory;
use wcf\system\WCF;

class Language extends DatabaseObject {
	public function getTitle() {
		return  WCF::getLanguage()->get($this->languageName);
	}
	
	public function getSystemLanguage() {
		return LanguageFactory::getInstance()->getLanguageByCode($this->languageCode);
	}
}
