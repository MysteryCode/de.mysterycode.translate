<?php

namespace translate\action;
use translate\data\language\category\LanguageCategoryList;
use translate\data\language\item\LanguageItemList;
use translate\data\language\item\value\LanguageItemValue;
use translate\data\language\LanguageCache;
use wcf\action\AbstractAction;
use wcf\system\exception\IllegalLinkException;
use wcf\util\XMLWriter;

class LanguageExportAction extends AbstractAction {
	/**
	 * language id
	 * @var	integer
	 */
	public $languageID = 0;
	
	/**
	 * language object
	 * @var	\translate\data\language\Language
	 */
	public $language = null;
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->languageID = intval($_REQUEST['id']);
		$this->language = LanguageCache::getInstance()->getLanguage($this->languageID);
		
		if ($this->language === null || !$this->language->languageID)
			throw new IllegalLinkException();
	}
	
	/**
	 * @inheritDoc
	 */
	public function execute() {
		parent::execute();
		
		$exportArray = $categories = [];
		
		$languageCategoryList = new LanguageCategoryList();
		$languageCategoryList->readObjects();
		
		foreach ($languageCategoryList->getObjects() as $languageCategory) {
			$categories[$languageCategory->languageCategoryID] = $languageCategory->languageCategory;
		}
		
		$tableName = LanguageItemValue::getDatabaseTableName();
		$tableAlias = LanguageItemValue::getDatabaseTableAlias();
		
		$languageItemList = new LanguageItemList();
		$languageItemList->sqlSelects .= $tableAlias . "value";
		$languageItemList->sqlJoins .= " INNER JOIN " . $tableName . " " . $tableAlias . " ON " . $tableAlias . ".languageItemID = language_item.languageItemID AND " . $tableAlias . ".checked = 1 AND " . $tableAlias . ".languageID = " . $this->languageID;
		//$languageItemList->getConditionBuilder()->add('language_item.checked = ?', [ 1 ]);
		//$languageItemList->getConditionBuilder()->add('language_item.languageID = ?', [ $this->languageID ]);
		$languageItemList->readObjects();
		
		foreach ($languageItemList->getObjects() as $languageItem) {
			if (!empty($categories[$languageItem->languageCategoryID]))
				$exportArray[$categories[$languageItem->languageCategoryID]][] = [ 'name' => $languageItem->languageItem, 'value' => $languageItem->languageItemValue ];
		}
		
		$xmlWriter = new XMLWriter();
		$xmlWriter->beginDocument('language', 'http://www.woltlab.com', 'http://www.woltlab.com/XSD/maelstrom/language.xsd');
		
		foreach ($exportArray as $category => $items) {
			$xmlWriter->startElement('category', [ 'name' =>  $category ]);
			
			foreach ($items as $item) {
				$xmlWriter->writeElement('item', $item['value'], [ 'name' => $item['name'] ]);
			}
			
			$xmlWriter->endElement();
		}
		
		@header('Content-Type: application/xml');
		echo $xmlWriter->endDocument();
		exit;
	}
}
