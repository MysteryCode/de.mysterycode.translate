<?php

namespace translate\data\package;
use translate\data\package\Package;
use translate\system\cache\builder\PackageCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

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
	}
}
