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
	protected $cachedObjects = array();

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = LanguageCacheBuilder::getInstance()->getData(array(), 'languages');
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
}
