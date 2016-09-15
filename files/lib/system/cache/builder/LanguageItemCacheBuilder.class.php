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
		$data = array(
			'items' => []
		);
		
		// get all items
		$languageItemList = new LanguageItemList();
		$languageItemList->sqlOrderBy = 'language_item.languageItemID ASC';
		$languageItemList->readObjects();
		$data['items'] = $languageItemList->getObjects();
		
		return $data;
	}
}
