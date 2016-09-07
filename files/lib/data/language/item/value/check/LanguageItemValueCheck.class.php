<?php

namespace translate\data\language\item\value\check;
use wcf\data\DatabaseObject;

class LanguageItemValueCheck extends DatabaseObject {
	/**
	 * @inheritdoc
	 */
	protected static $databaseTableIndexName = 'languageItemCheckID';
	
	/**
	 * @inheritdoc
	 */
	protected static $databaseTableName = 'language_item_check';
}
