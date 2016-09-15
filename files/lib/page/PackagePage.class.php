<?php

namespace translate\page;
use translate\data\package\PackageCache;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class PackagePage extends AbstractPage {
	public $packageID = null;
	public $package = null;
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->packageID = $_REQUEST['id'];
		$this->package = PackageCache::getInstance()->getPackage($this->packageID);
		
		if ($this->package === null)
			throw new IllegalLinkException();
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'package' => $this->package
		]);
	}
}
