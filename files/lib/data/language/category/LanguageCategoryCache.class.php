<?php

namespace translate\data\language\category;
use translate\system\cache\builder\LanguageCategoryCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class LanguageCategoryCache extends SingletonFactory {
	/**
	 * cached language categories
	 * 
	 * @var \translate\data\language\category\LanguageCategory[]
	 */
	protected $cachedObjects = array();

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageCategoryCacheBuilder::getInstance()->getData(array(), 'categories');
	}

	/**
	 * Returns the language category with the given object id from cache.
	 *
	 * @param integer $objectID        	
	 * @return \translate\data\language\category\LanguageCategory
	 */
	public function getLanguageCategory ($objectID) {
		if (! isset($this->cachedObjects[$objectID])) {
			return null;
		}
		
		return $this->cachedObjects[$objectID];
	}

	/**
	 * Returns a list of all language categories.
	 *
	 * @return \translate\data\language\category\LanguageCategory[]
	 */
	public function getLanguageCategories () {
		return $this->cachedObjects;
	}
}
