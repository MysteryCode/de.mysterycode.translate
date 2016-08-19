<?php

namespace translate\system\option;
use wcf\data\option\Option;
use wcf\system\option\MultiSelectOptionType;
use translate\data\language\LanguageList;

class LanguageMultiSelectOptionType extends MultiSelectOptionType {
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
