<?php

namespace translate\data\language\item;
use translate\data\language\item\LanguageItem;
use translate\system\cache\builder\LanguageItemCacheBuilder;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;

class LanguageItemEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = LanguageItem::class;
	
	/**
	 * @see	\wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		LanguageItemCacheBuilder::getInstance()->reset();
	}
}
