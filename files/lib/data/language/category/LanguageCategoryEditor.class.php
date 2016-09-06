<?php

namespace translate\data\language\category;
use translate\system\cache\builder\LanguageCategoryCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

class LanguageCategoryEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'translate\data\language\category\LanguageCategory';
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		LanguageCategoryCacheBuilder::getInstance()->reset();
	}
}
