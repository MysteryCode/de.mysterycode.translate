<?php

namespace translate\data\language;
use translate\data\language\Language;
use translate\system\cache\builder\LanguageCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\WCF;

class LanguageEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = Language::class;
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		LanguageCacheBuilder::getInstance()->reset();
		
		// set stat columns on languages
		$sql = "UPDATE translate" . WCF_N . "_language language
			SET variables = (
				SELECT COUNT(language_item_value.languageItemValueID)
				FROM translate" . WCF_N . "_language_item_value language_item_value
				WHERE language_item_value.languageID = language.languageID
			), variablesChecked = (
				SELECT COUNT(language_item_value2.languageItemValueID)
				FROM translate" . WCF_N . "_language_item_value language_item_value2
				WHERE language_item_value2.languageID = language.languageID
					AND language_item_value2.checked = ?
			)";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ 1 ]);
	}
}
