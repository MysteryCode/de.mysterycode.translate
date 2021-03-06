<?php

namespace translate\data\package\version;
use translate\data\package\version\PackageVersion;
use translate\system\cache\builder\PackageVersionCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

class PackageVersionEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = PackageVersion::class;
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
// 		static::resetPermissionCache();
		PackageVersionCacheBuilder::getInstance()->reset();
	}
}
