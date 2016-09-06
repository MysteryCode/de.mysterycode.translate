<?php

namespace translate\action;
use translate\data\language\LanguageCache;
use wcf\action\AbstractAction;
use wcf\system\exception\IllegalLinkException;
use translate\data\language\item\LanguageItemList;
use wcf\util\XMLWriter;
use translate\data\language\category\LanguageCategoryList;

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
		
		$languageItemList = new LanguageItemList();
		$languageItemList->getConditionBuilder()->add('language_item.checked = ?', [ 1 ]);
		$languageItemList->getConditionBuilder()->add('language_item.languageID = ?', [ $this->languageID ]);
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
