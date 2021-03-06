<?php

namespace translate\system\option;
use translate\data\language\LanguageList;
use wcf\data\option\Option;
use wcf\system\option\MultiSelectOptionType;

class LanguageMultiSelectOptionType extends MultiSelectOptionType {
	protected function getSelectOptions(Option $option) {
		$languages = [];
		
		$languageList = new LanguageList();
		$languageList->readObjects();
		$languageList = $languageList->getObjects();
		
		foreach ($languageList as $language) {
			$languages[$language->languageCode] = $language->getTitle();
		}
		
		return $languages;
	}
}
