<?php

namespace translate\system\cache\builder;
use translate\data\language\LanguageList;
use wcf\system\cache\builder\AbstractCacheBuilder;
use wcf\system\WCF;

class LanguageCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see \wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild (array $parameters) {
		$data = [
			'languages' => []
		];
		
// 		// set stat columns on languages
// 		$sql = "UPDATE translate" . WCF_N . "_language language
// 			SET variables = (
// 				SELECT COUNT(language_item_value.languageItemValueID)
// 				FROM translate" . WCF_N . "_language_item_value language_item_value
// 				WHERE language_item_value.languageID = language.languageID
// 			), variablesChecked = (
// 				SELECT COUNT(language_item_value2.languageItemValueID)
// 				FROM translate" . WCF_N . "_language_item_value language_item_value2
// 				WHERE language_item_value2.languageID = language.languageID
// 					AND language_item_value2.checked = ?
// 			)";
// 		$statement = WCF::getDB()->prepareStatement($sql);
// 		$statement->execute([ 1 ]);
		
		// get all languages
		$languageList = new LanguageList();
		$languageList->sqlOrderBy = 'language.languageID ASC';
		$languageList->readObjects();
		$data['languages'] = $languageList->getObjects();
		
		return $data;
	}
}
