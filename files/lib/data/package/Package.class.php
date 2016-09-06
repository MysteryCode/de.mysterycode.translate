<?php

namespace translate\data\package;
use translate\data\package\version\PackageVersionList;
use wcf\data\DatabaseObject;
use wcf\data\package\Package as WCFPackage;

class Package extends DatabaseObject {
	protected $currentVersion = null;
	
	public function getTitle() {
		return  WCF::getLanguage()->get($this->title);
	}
	
	public function getCurrentVersion() {
		if ($this->currentVersion === null) {
			$versionList = new PackageVersionList();
			$versionList->getConditionBuilder()->add('version.packageID = ?', [ $this->packageID ]);
			$versionList->sqlOrderBy = 'version.time DESC';
			$versionList->readObjects();
			
			foreach ($versionList as $version) {
				if (WCFPackage::compareVersion($this->currentVersion->version, $version->version, '<'))
					$this->currentVersion = $version;
			}
		}
		
		return $this->currentVersion;
	}
}
