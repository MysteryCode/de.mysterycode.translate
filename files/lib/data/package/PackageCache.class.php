<?php

namespace translate\data\package;
use translate\system\cache\builder\PackageCacheBuilder;
use wcf\system\SingletonFactory;
use wcf\system\WCF;

class PackageCache extends SingletonFactory {
	/**
	 * cached packages
	 * 
	 * @var \translate\data\package\Package[]
	 */
	protected $cachedObjects = array();

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = PackageCacheBuilder::getInstance()->getData(array(), 'packages');
	}

	/**
	 * Returns the package with the given object id from cache.
	 *
	 * @param integer $objectID        	
	 * @return \translate\data\package\Package
	 */
	public function getPackage ($objectID) {
		if (! isset($this->cachedObjects[$objectID])) {
			return null;
		}
		
		return $this->cachedObjects[$objectID];
	}

	/**
	 * Returns a list of all packages.
	 *
	 * @return \translate\data\package\Package[]
	 */
	public function getPackages () {
		return $this->cachedObjects;
	}
}
