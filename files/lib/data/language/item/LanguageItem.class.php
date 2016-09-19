<?php

namespace translate\data\language\item;
use translate\data\language\category\LanguageCategoryCache;
use translate\data\language\item\value\LanguageItemValueList;
use translate\data\language\LanguageCache;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * @property-read	integer		$languageItemID		unique id of the language item
 * @property-read	string		$languageItem		unique name/identifier the language item
 * @property-read	integer		$languageCategoryID		unique id of the language category the item belongs to
 * @property-read	integer		$packageID			unique id of the package the item belongs to
 */
class LanguageItem extends DatabaseObject {
	/**
	 * @inheritdoc
	 */
	protected static $databaseTableIndexName = 'languageItemID';
	
	/**
	 * array with value/translation objects
	 * 
	 * @var \translate\data\language\item\value\LanguageItemValue[]
	 */
	protected $translations = [];
	
	/**
	 * @inheritdoc
	 */
	public function __construct($id, array $row = null, DatabaseObject $object = null) {
		parent::__construct($id, $row, $object);
		
		$this->getTranslations();
	}
	
	/**
	 * check translation status of the current language item
	 * return values:
	 *     -1: not translated yet
	 *      0: translated, but not confirmed
	 *      1:	translated and confirmed
	 * 
	 * @param integer $languageID
	 * @return integer|integer[]
	 */
	public function getTranslationStatus($languageID = 0) {
		if ($languageID) {
			
			if ($this->translations === null)
				$this->getTranslations();
			
			if (empty($this->translations[$languageID])) {
				return -1;
			} else {
				if (!$this->translations[$languageID]->checked)
					return 0;
				else
					return 1;
			}
		} else {
			$languages = LanguageCache::getInstance()->getLanguages();
			
			$result = [];
			foreach ($languages as $language) {
				$result[] = $this->getTranslationStatus($language->languageID);
			}
			
			return $result;
		}
	}
	
	/**
	 * Returns an array with translations
	 * identified by the languageID as key
	 * 
	 * @return null|\translate\data\language\item\value\LanguageItemValue[]
	 */
	public function getTranslations() {
		if ($this->translations === null || empty($this->translations)) {
			$valueList = new LanguageItemValueList();
			$valueList->getConditionBuilder()->add('language_item_value.languageItemID = ?', [ $this->languageItemID ]);
			$valueList->readObjects();
			
			foreach ($valueList->getObjects() as $translation) {
				$this->translations[$translation->languageID] = $translation;
			}
		}
		
		return $this->translations;
	}
	
	/**
	 * Returns the language category of the current language item
	 * 
	 * @return \translate\data\language\category\LanguageCategory
	 */
	public function getCategory() {
		return LanguageCategoryCache::getInstance()->getLanguageCategory($this->languageCategoryID);
	}
	
	/**
	 * Returns the language item object uncached based on the given identifier
	 *
	 * @param string $identifier
	 * @return NULL|\translate\data\language\item\LanguageItem
	 */
	public static function getLanguageItemByIdentifier($identifier) {
		$sql = "SELECT *
			FROM translate". WCF_N . "_language_item
			WHERE languageItem = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ $identifier ]);
		$result = $statement->fetchArray();
		
		if ($result === false)
			return null;
		
		return new self(null, $result);
	}
}
