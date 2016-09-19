<?php

namespace translate\data\language\item\value\check;
use wcf\data\DatabaseObject;

/**
 * @property-read	integer		$languageItemCheckID		unique id of the check log
 * @property-read	integer		$languageItemID		unique id of the checked language item
 * @property-read	integer		$languageItemValueID		unique id of the checked translation
 * @property-read	integer		$userID			unique id of the user who checked this
 * @property-read	string		$username			username of the user who checked this
 * @property-read	integer		$time			unix timestamp of the check
 * @property-read	string		$ipAddress			ipaddress of the user who checked this
 */
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
