<?php

namespace translate\system\cache\builder;
use translate\data\language\category\LanguageCategoryList;
use wcf\system\cache\builder\AbstractCacheBuilder;
use wcf\system\WCF;

class LanguageCategoryCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see \wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild (array $parameters) {
		$data = array(
			'categories' => []
		);
		
		// get all categories
		$languageCategoryList = new LanguageCategoryList();
		$languageCategoryList->sqlOrderBy = 'language_category.languageCategoryID ASC';
		$languageCategoryList->readObjects();
		$data['categories'] = $languageCategoryList->getObjects();
		
		return $data;
	}
}
