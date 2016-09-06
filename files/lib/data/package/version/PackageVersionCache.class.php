<?php

namespace translate\data\package\version;
use translate\system\cache\builder\PackageVersionCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class PackageVersionCache extends SingletonFactory {
	/**
	 * cached package versions
	 * 
	 * @var \translate\data\package\version\PackageVersion[]
	 */
	protected $cachedObjects = array();

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = PackageVersionCacheBuilder::getInstance()->getData(array(), 'versions');
	}

	/**
	 * Returns the package version with the given object id from cache.
	 *
	 * @param integer $objectID        	
	 * @return \translate\data\package\version\PackageVersion
	 */
	public function getPackageVersion ($objectID) {
		if (! isset($this->cachedObjects[$objectID])) {
			return null;
		}
		
		return $this->cachedObjects[$objectID];
	}

	/**
	 * Returns a list of all package versions.
	 *
	 * @return \translate\data\package\version\PackageVersion[]
	 */
	public function getPackageVersions () {
		return $this->cachedObjects;
	}
}
