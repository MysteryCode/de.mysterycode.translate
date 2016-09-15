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
	 * identifier as array-key
	 * packageID as value
	 * 
	 * @var integer[]
	 */
	protected $packageIDs = [];

	/**
	 * @see \wcf\system\SingletonFactory::init()
	 */
	protected function init () {
		$this->cachedObjects = PackageCacheBuilder::getInstance()->getData(array(), 'packages');
		
		foreach ($this->cachedObjects as $package) {
			$this->packageIDs[$package->identifier] = $package->packageID;
		}
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
	
	/**
	 * Returns the packageID of the package matching the given identifier string
	 *  
	 * @param string $identifier
	 * @return NULL|\translate\data\package\integer
	 */
	public function getPackageIDByIdentifier($identifier) {
		if (empty($this->packageIDs[$identifier]))
			return null;
		
		return $this->packageIDs[$identifier];
	}
	
	/**
	 * Returns the package object matching the given identifier string
	 * 
	 * @param string $identifier
	 * @return NULL|\translate\data\package\Package
	 */
	public function getPackageByIdentifier($identifier) {
		$packageID = $this->getPackageIDByIdentifier($identifier);
		if (empty($packageID) || $packageID === null)
			return null;
		
		return self::getInstance()->getPackage($packageID);
	}
}
