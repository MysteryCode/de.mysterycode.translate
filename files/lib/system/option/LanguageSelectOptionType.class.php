<?php

namespace translate\system\option;
use translate\data\language\LanguageList;
use wcf\data\option\Option;
use wcf\system\option\SelectOptionType;

class LanguageSelectOptionType extends SelectOptionType {
	protected function getSelectOptions(Option $option) {
		$languages = array();
		
		$languageList = new LanguageList();
		$languageList->readObjects();
		$languageList = $languageList->getObjects();
		
		foreach ($languageList as $language) {
			$languages[$language->languageCode] = $language->getTitle();
		}
		
		return $languages;
	}
}
