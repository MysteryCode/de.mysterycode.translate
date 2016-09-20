<?php

namespace translate\data\language;
use translate\system\cache\builder\LanguageCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class LanguageCache extends SingletonFactory {
	/**
	 * cached languages
	 * 
	 * @var \translate\data\language\Language[]
	 */
	protected $cachedObjects = [];
	
	/**
	 * language code as key
	 * languageID as value
	 * 
	 * @var integer[]
	 */
	protected $languageIDs = [];
	
	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageCacheBuilder::getInstance()->getData([], 'languages');
		
		foreach ($this->cachedObjects as $language) {
			$this->languageIDs[$language->languageCode] = $language->languageID;
		}
	}

	/**
	 * Returns the language with the given object id from cache.
	 *
	 * @param integer $objectID        	
	 * @return \translate\data\language\Language
	 */
	public function getLanguage ($objectID) {
		if (! isset($this->cachedObjects[$objectID])) {
			return null;
		}
		
		return $this->cachedObjects[$objectID];
	}

	/**
	 * Returns a list of all languages.
	 *
	 * @return \translate\data\language\Language[]
	 */
	public function getLanguages () {
		return $this->cachedObjects;
	}
	
	/**
	 * Returns the if of the language matching the given languageCode
	 * 
	 * @param string $languageCode
	 * @return NULL|integer
	 */
	public function getLanguageIDByCode($languageCode) {
		if (empty($this->languageIDs[$languageCode]))
			return null;
		
		return $this->languageIDs[$languageCode];
	}
	
	/**
	 * Returns the language object matching the given languageCode
	 * 
	 * @param string $languageCode
	 * @return NULL|\translate\data\language\Language
	 */
	public function getLanguageByCode($languageCode) {
		$languageID = $this->getLanguageIDByCode($languageCode);
		if (empty($languageID))
			return null;
		
		return $this->getLanguage($languageID);
	}
}
