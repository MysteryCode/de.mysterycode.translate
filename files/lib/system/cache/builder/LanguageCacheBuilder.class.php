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
		
		// get all languages
		$languageList = new LanguageList();
		$languageList->sqlOrderBy = 'language.languageID ASC';
		$languageList->readObjects();
		$data['languages'] = $languageList->getObjects();
		
		return $data;
	}
}
