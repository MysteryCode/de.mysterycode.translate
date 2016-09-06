<?php

namespace translate\data\language\item;
use translate\system\cache\builder\LanguageItemCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

class LanguageItemEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'translate\data\language\item\LanguageItem';
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		LanguageItemCacheBuilder::getInstance()->reset();
	}
}
