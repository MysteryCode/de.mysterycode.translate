<?php

namespace translate\system\search;
use translate\data\language\SearchResultLanguageList;
use wcf\system\search\AbstractSearchableObjectType;
use wcf\system\WCF;

class LanguageSearch extends AbstractSearchableObjectType {
	/**
	 * obect data cache
	 * @var	array
	 */
	public $objectCache = [];
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getTableName()
	 */
	public function getTableName() {
		return 'translate'.WCF_N.'_language';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getSubjectFieldName()
	 */
	public function getSubjectFieldName() {
		return $this->getTableName().'.i18nlanguageName';
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
		return "''";
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::getIDFieldName()
	 */
	public function getIDFieldName() {
		return $this->getTableName().'.languageID';
	}
	
	/**
	 * @see	\wcf\system\search\ISearchableObjectType::cacheObjects()
	 */
	public function cacheObjects(array $objectIDs, array $additionalData = null) {
		$languageList = new SearchResultLanguageList();
		$languageList->getConditionBuilder()->add('language.languageID IN (?)', [ $objectIDs ]);
		$languageList->readObjects();
		
		foreach ($languageList->getObjects() as $language) {
			$this->objectCache[$language->languageID] = $language;
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
