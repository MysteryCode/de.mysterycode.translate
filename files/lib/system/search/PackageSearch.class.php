<?php

namespace translate\system\search;
use translate\data\package\SearchResultPackageList;
use wcf\system\search\AbstractSearchableObjectType;
use wcf\system\WCF;

class PackageSearch extends AbstractSearchableObjectType {
	/**
	 * obect data cache
	 * @var	array
	 */
	public $objectCache = [];
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getTableName()
	 */
	public function getTableName() {
		return 'translate'.WCF_N.'_package';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getSubjectFieldName()
	 */
	public function getSubjectFieldName() {
		return $this->getTableName().'.title';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getTimeFieldName()
	 */
	public function getTimeFieldName() {
		return 0;
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getUsernameFieldName()
	 */
	public function getUsernameFieldName() {
		return $this->getTableName().'.username';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getIDFieldName()
	 */
	public function getIDFieldName() {
		return $this->getTableName().'.packageID';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::cacheObjects()
	 */
	public function cacheObjects(array $objectIDs, array $additionalData = null) {
		$packageList = new SearchResultPackageList();
		$packageList->getConditionBuilder()->add('package.packageID IN (?)', [ $objectIDs ]);
		$packageList->readObjects();
		
		foreach ($packageList->getObjects() as $package) {
			$this->objectCache[$package->packageID] = $package;
		}
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getObject()
	 */
	public function getObject($objectID) {
		if (isset($this->objectCache[$objectID]))
			return $this->objectCache[$objectID];
		
		return null;
	}
}
