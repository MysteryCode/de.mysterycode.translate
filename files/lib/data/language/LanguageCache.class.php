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
	 * Returns a list of all accessible languages.
	 *
	 * @return \translate\data\language\Language[]
	 */
	public function getAccessibleLanguages () {
		$languageList = [];
		$unaccessible = WCF::getUser()->getUserOption('translateExcludedLanguages') ? explode("\n", WCF::getUser()->getUserOption('translateExcludedLanguages')) : [];
		
		foreach ($this->cachedObjects as $language) {
			if (!in_array($language->languageCode, $unaccessible))
				$languageList[] = $language;
		}
		
		return $languageList;
			
	}

	/**
	 * Returns a list of ids of all accessible languages.
	 *
	 * @return \translate\data\language\Language[]
	 */
	public function getAccessibleLanguageIDs () {
		$languageList = $this->getAccessibleLanguages();
		$accessibleIDs = [];
		foreach ($languageList as $language) {
			$accessibleIDs[] = $language->languageID;
		}
		
		return $accessibleIDs;
			
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
