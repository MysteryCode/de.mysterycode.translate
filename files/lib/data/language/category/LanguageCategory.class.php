<?php

namespace translate\data\language\category;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

class LanguageCategory extends DatabaseObject {
	/**
	 * @inheritdoc
	 */
	protected static $databaseTableIndexName = 'languageCategoryID';
	
	/**
	 * Returns the language category object uncached based on the given categoryName
	 * 
	 * @param string $categoryName
	 * @return NULL|\translate\data\language\category\LanguageCategory
	 */
	public static function getLanguageCategoryByName($categoryName) {
		$sql = "SELECT *
			FROM translate". WCF_N . "_language_category
			WHERE languageCategory = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ $categoryName ]);
		$result = $statement->fetchArray();
		
		if ($result === false)
			return null;
		
		return new self(null, $result);
	}
}
