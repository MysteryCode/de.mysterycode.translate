<?php

namespace translate\data;
use wcf\data\DatabaseObjectList;
use wcf\util\StringUtil;

abstract class I18nDatabaseObjectList extends DatabaseObjectList {
	/**
	 * Array of fields filled with language items
	 * this slows down the system, use this only when sorting
	 * based on an i18n-value.
	 * The value represents the original field name.
	 * The key represents the new field name and is optional.
	 * If no key is provided, the new field will be 'i18n'.$value
	 * 
	 * use table.field shema!
	 * 
	 * @example   [ 'title' => 'titleSortField' ]
	 * 
	 * @var string[]
	 */
	public $i18nFields = [];
	
	/**
	 * @inheritDoc
	 */
	public function readObjects() {
		if (!empty($this->i18nFields)) {
			foreach ($this->i18nFields as $key => $value) {
				$matchTable =  'i18n_' . StringUtil::getHash($value);
				
				if (!empty($this->sqlSelects))
					$this->sqlSelects .= ", ";
				
				if (is_numeric($key)) {
					$tmp = explode('.', $value);
					
					if (count($tmp) == 2)
						$key = 'i18n' . $tmp[1];
					else if (count($tmp) > 2)
						$key = 'i18n' . $tmp[count($tmp) - 1];
					else
						$key = 'i18n' . $value;
				}
				
				$this->sqlSelects .= "IF (" . $matchTable . ".languageItemValue IS NULL, " . $value . ", " . $matchTable . ".languageItemValue ) AS " . $key;
				$this->sqlJoins .= " LEFT JOIN wcf" . WCF_N . "_language_item " . $matchTable . " ON " . $matchTable . ".languageItem = " . $value . " AND " . $matchTable . ".languageID = " . WCF::getLanguage()->languageID;
			}
		}
		
		parent::readObjects();
	}
}
