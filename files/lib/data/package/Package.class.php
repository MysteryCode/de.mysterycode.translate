<?php

namespace translate\data\package;
use translate\data\package\version\PackageVersionList;
use wcf\data\package\Package as WCFPackage;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

class Package extends DatabaseObject implements IRouteController {
	protected $currentVersion = null;
	
	public function getTitle() {
		return  WCF::getLanguage()->get($this->title);
	}
	
	public function getCurrentVersion() {
		if ($this->currentVersion === null) {
			$versionList = new PackageVersionList();
			$versionList->getConditionBuilder()->add('package_version.packageID = ?', [ $this->packageID ]);
			$versionList->sqlOrderBy = 'package_version.time DESC';
			$versionList->readObjects();
			
			foreach ($versionList as $version) {
				if ($this->currentVersion === null || WCFPackage::compareVersion($this->currentVersion->version, $version->version, '<'))
					$this->currentVersion = $version;
			}
		}
		
		return $this->currentVersion;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getLink() {
		return LinkHandler::getInstance()->getLink('Package', [
			'application' => 'translate',
			'object' => $this,
			'forceFrontend' => true
		]);
	}
}
