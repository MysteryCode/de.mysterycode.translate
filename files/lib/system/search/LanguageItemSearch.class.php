<?php

namespace translate\system\search;
use translate\data\language\item\SearchResultLanguageItemList;
use wcf\system\search\AbstractSearchableObjectType;
use wcf\system\WCF;

class LanguageItemSearch extends AbstractSearchableObjectType {
	/**
	 * obect data cache
	 * @var	array
	 */
	public $objectCache = [];
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getTableName()
	 */
	public function getTableName() {
		return 'translate'.WCF_N.'_language_item';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getJoins() {
		return 'INNER JOIN translate'.WCF_N.'_package ON translate'.WCF_N.'_package.packageID = translate'.WCF_N.'_language_item.packageID';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getSubjectFieldName()
	 */
	public function getSubjectFieldName() {
		return $this->getTableName().'.languageItem';
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
		return 'translate'.WCF_N.'_package.username';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getIDFieldName()
	 */
	public function getIDFieldName() {
		return $this->getTableName().'.languageItemID';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::cacheObjects()
	 */
	public function cacheObjects(array $objectIDs, array $additionalData = null) {
		$languageItemList = new SearchResultLanguageItemList();
		$languageItemList->getConditionBuilder()->add('language_item.languageItemID IN (?)', [ $objectIDs ]);
		$languageItemList->readObjects();
		
		foreach ($languageItemList->getObjects() as $languageItem) {
			$this->objectCache[$languageItem->languageItemID] = $languageItem;
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
