<?php

namespace translate\data\language\item\value;
use translate\data\language\item\LanguageItemCache;
use translate\data\language\LanguageCache;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * @property-read	integer		$languageItemValueID		unique id of the translation
 * @property-read	integer		$languageID		unique id of the language this translation belongs to
 * @property-read	integer		$languageItemID		unique id of the language item this translation belongs to
 * @property-read	string		$languageItemValue		translated content of the language item (translation)
 * @property-read	boolean		$checked			true if the translation has been checked by several users, false if not
 */
class LanguageItemValue extends DatabaseObject {
	/**
	 * @inheritdoc
	 */
	protected static $databaseTableIndexName = 'languageItemValueID';
	
	/**
	 * Returns $limit random unchecked translations
	 * not already checked by the current user in no currently
	 * excluded language.
	 * 
	 * @param integer $limit maximum amount of searched values
	 * @return \translate\data\language\item\value\LanguageItemValue[]
	 */
	public static function getUncheckedLanguageItemValues($limit = 1) {
		$sql = "SELECT languageItemValueID
			FROM translate" . WCF_N . "_language_item_check
			WHERE userID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ WCF::getUser()->userID ]);
		
		$excludes = $statement->fetchAll(\PDO::FETCH_COLUMN);
		
		$valueList = new LanguageItemValueList();
		$valueList->getConditionBuilder()->add('language_item_value.checked <> ?', [ 1 ]);
		$valueList->getConditionBuilder()->add('language_item_value.languageID NOT IN (?)', [ WCF::getUser()->getUserOption('translateExcludedLanguages') ]);
		if (!empty($excludes))
			$valueList->getConditionBuilder()->add('language_item_value.languageItemValueID NOT IN (?)', [ $excludes ]);
		$valueList->sqlLimit = $limit;
		
		return $valueList->getObjects();
	}
	
	/**
	 * Returns the language object of this translation
	 * 
	 * @return \translate\data\language\Language
	 */
	public function getLanguage() {
		return LanguageCache::getInstance()->getLanguage($this->languageID);
	}
	
	/**
	 * Returns the language item object of this translation
	 * 
	 * @return \translate\data\language\item\LanguageItem
	 */
	public function getLanguageItem() {
		return LanguageItemCache::getInstance()->getLanguageItem($this->languageItemID);
	}
	
	/**
	 * Get translation status of this translation
	 * 
	 * return values:
	 *      0: translated, but not confirmed
	 *      1:	translated and confirmed
	 * 
	 * @return 0|1
	 */
	public function getStatus() {
		if (!$this->checked)
			return 0;
		else
			return 1;
	}
}
