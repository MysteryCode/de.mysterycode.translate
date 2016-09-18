<?php

namespace translate\system\cache\builder;
use translate\data\language\item\LanguageItemList;
use wcf\system\cache\builder\AbstractCacheBuilder;
use wcf\system\WCF;

class LanguageItemCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see \wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild (array $parameters) {
		$data = [
			'items' => []
		];
		
		// get all items
		$languageItemList = new LanguageItemList();
		$languageItemList->sqlOrderBy = 'language_item.languageItemID ASC';
		$languageItemList->readObjects();
		$data['items'] = $languageItemList->getObjects();
		
		// set stat columns on languages
		$sql = "UPDATE translate" . WCF_N . "_language
			SET variables = (
				SELECT COUNT(language_item_value.languageItemValueID)
				FROM translate" . WCF_N . "_language_item_value language_item_value
				WHERE language_item_value.languageID = languageID
			)";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		$sql = "UPDATE translate" . WCF_N . "_language
			SET variablesChecked = (
				SELECT COUNT(language_item_value.languageItemValueID)
				FROM translate" . WCF_N . "_language_item_value language_item_value
				WHERE language_item_value.languageID = languageID
					AND language_item_value.checked = ?
			)";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute([ 1 ]);
		
		return $data;
	}
}
