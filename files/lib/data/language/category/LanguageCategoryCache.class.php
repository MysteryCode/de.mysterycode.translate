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
	protected $cachedObjects = [];
	
	/**
	 * categoryName as array-key
	 * categoryID as value
	 *
	 * @var integer[]
	 */
	protected $categoryIDs = [];

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageCategoryCacheBuilder::getInstance()->getData([], 'categories');
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
	
	/**
	 * Returns the categoryID of the category matching the given name
	 *
	 * @param string $categoryName
	 * @return NULL|integer
	 */
	public function getLanguageCategoryIDByName($categoryName) {
		if (empty($this->categoryIDs[$categoryName]))
			return null;
		
		return $this->categoryIDs[$categoryName];
	}
	
	/**
	 * Returns the category object matching the given name
	 *
	 * @param string $categoryName
	 * @return NULL|\translate\data\language\category\LanguageCategory
	 */
	public function getLanguageCategoryByName($categoryName) {
		$categoryID = $this->getLanguageCategoryIDByName($categoryName);
		if (empty($categoryID))
			return null;
		
		return $this->getLanguageCategory($categoryID);
	}
}
