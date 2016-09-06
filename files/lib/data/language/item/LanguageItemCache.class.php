<?php

namespace translate\data\language\item;
use translate\system\cache\builder\LanguageItemCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class LanguageItemCache extends SingletonFactory {
	/**
	 * cached language items
	 * 
	 * @var \translate\data\language\item\LanguageItem[]
	 */
	protected $cachedObjects = array();

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageItemCacheBuilder::getInstance()->getData(array(), 'items');
	}

	/**
	 * Returns the language item with the given object id from cache.
	 *
	 * @param integer $objectID        	
	 * @return \translate\data\language\item\LanguageItem
	 */
	public function getLanguageItem ($objectID) {
		if (! isset($this->cachedObjects[$objectID])) {
			return null;
		}
		
		return $this->cachedObjects[$objectID];
	}

	/**
	 * Returns a list of all language items.
	 *
	 * @return \translate\data\language\item\LanguageItem[]
	 */
	public function getLanguageItems () {
		return $this->cachedObjects;
	}
}
