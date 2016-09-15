<?php

namespace translate\data\language;
use translate\data\language\Language;
use translate\system\cache\builder\LanguageCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

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
	}
}
