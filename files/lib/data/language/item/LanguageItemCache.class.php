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
	protected $cachedObjects = [];

	/**
	 * languageItem as key
	 * languageItemID as value
	 *
	 * @var integer[]
	 */
	protected $itemIDs = [];

	/**
	 *
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageItemCacheBuilder::getInstance()->getData([], 'items');
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

	/**
	 * Returns the id of the language matching the given identifier
	 *
	 * @param string $languageItem        	
	 * @return NULL|integer
	 */
	public function getLanguageItemIDByIdentifier ($languageItem) {
		if (empty($this->languageIDs[$languageItem])) return null;
		
		return $this->languageIDs[$languageItem];
	}

	/**
	 * Returns the language item object matching the given identifier
	 *
	 * @param string $languageItem        	
	 * @return NULL|\translate\data\language\item\LanguageItem
	 */
	public function getLanguageItemByIdentifier ($languageItem) {
		$itemID = $this->getLanguageIDByCode($languageItem);
		if (empty($itemID)) return null;
		
		return $this->getLanguageItemIDByIdentifier($itemID);
	}
}
