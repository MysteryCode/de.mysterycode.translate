<?php

namespace translate\data\package;
use translate\data\package\Package;
use translate\system\cache\builder\PackageCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\WCF;

class PackageEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = Package::class;
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
// 		static::resetPermissionCache();
		PackageCacheBuilder::getInstance()->reset();
		
		// set stat columns on packages
		$sql = "UPDATE translate" . WCF_N . "_package package
			SET variables = (
				SELECT COUNT(language_item.languageItemID)
				FROM translate" . WCF_N . "_language_item language_item
				WHERE language_item.packageID = package.packageID
			), variablesChecked = (
				SELECT COUNT(language_item_value2.languageItemValueID)
				FROM translate" . WCF_N . "_language_item_value language_item_value2
				WHERE language_item_value2.languageItemID IN (
					SELECT language_item2.languageItemID
					FROM translate" . WCF_N . "_language_item language_item2
					WHERE language_item2.packageID = package.packageID
				)
					AND language_item_value2.checked = ?
			)";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ 1 ]);
	}
}
