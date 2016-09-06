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
		$data = array(
			'packages' => array()
		);
		
		// get all packages
		$packageList = new PackageList();
		$packageList->sqlOrderBy = 'package.packageID ASC';
		$packageList->readObjects();
		$data['packages'] = $packageList->getObjects();
		
		return $data;
	}
}
