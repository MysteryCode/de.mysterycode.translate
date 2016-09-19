<?php

namespace translate\system\cache\builder;
use translate\data\package\PackageList;
use wcf\system\cache\builder\AbstractCacheBuilder;
use wcf\system\WCF;

class PackageCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see \wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild (array $parameters) {
		$data = [
			'packages' => []
		];
		
// 		// set stat columns on packages
// 		$sql = "UPDATE translate" . WCF_N . "_package package
// 			SET variables = (
// 				SELECT COUNT(language_item_value.languageItemValueID)
// 				FROM translate" . WCF_N . "_language_item_value language_item_value
// 				WHERE language_item_value.languageItemID IN (
// 					SELECT language_item.languageItemID
// 					FROM translate" . WCF_N . "_language_item language_item
// 					WHERE language_item.packageID = package.packageID
// 				)
// 			), variablesChecked = (
// 				SELECT COUNT(language_item_value2.languageItemValueID)
// 				FROM translate" . WCF_N . "_language_item_value language_item_value2
// 				WHERE language_item_value2.languageItemID IN (
// 					SELECT language_item2.languageItemID
// 					FROM translate" . WCF_N . "_language_item language_item2
// 					WHERE language_item2.packageID = package.packageID
// 				)
// 					AND language_item_value2.checked = ?
// 			)";
// 		$statement = WCF::getDB()->prepareStatement($sql);
// 		$statement->execute([ 1 ]);
		
		// get all packages
		$packageList = new PackageList();
		$packageList->sqlOrderBy = 'package.packageID ASC';
		$packageList->readObjects();
		$data['packages'] = $packageList->getObjects();
		
		return $data;
	}
}
