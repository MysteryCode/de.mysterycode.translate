<?php

namespace translate\data\language\item\value;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

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
		
		$excludes = [];
		while ($row = $statement->fetchArray()) {
			$excludes[] = $row['languageItemValueID'];
		}
		
		$valueList = new LanguageItemValueList();
		$valueList->getConditionBuilder()->add('language_item_value.checked <> ?', [ 1 ]);
		$valueList->getConditionBuilder()->add('language_item_value.languageID NOT IN (?)', [ WCF::getUser()->getUserOption('translateExcludedLanguages') ]);
		if (!empty($excludes))
			$valueList->getConditionBuilder()->add('language_item_value.languageItemValueID NOT IN (?)', [ $excludes ]);
		$valueList->sqlLimit = $limit;
		
		return $valueList->getObjects();
	}
}
