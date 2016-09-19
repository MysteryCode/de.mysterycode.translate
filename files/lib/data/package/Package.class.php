<?php

namespace translate\data\package;
use translate\data\package\version\PackageVersionList;
use wcf\data\package\Package as WCFPackage;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * @property-read	integer		$packageID			unique id of the package
 * @property-read	string		$identifier		identifier of the package
 * @property-read	string		$title			title
 * @property-read	string		$description		description of the package
 * @property-read	boolean		$application		package is a standalone application
 * @property-read	boolean		$isunique			package can be installed once only (tempest)
 * @property-read	string		$plugin			package this package is based on / is a plugin of (tempest)
 * @property-read	string		$author			name of the author(s)
 * @property-read	string		$authorUrl			author's website
 * @property-read	string		$supportUrl		URL to a website where you can get support for this package
 * @property-read	string		$github			GitHub clone URL (with .git)
 * @property-read	integer		$variables			amount of variables that belong to this package
 * @property-read	integer		$variablesChecked		amount of translated and checked variables that belong to this package
 */
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
