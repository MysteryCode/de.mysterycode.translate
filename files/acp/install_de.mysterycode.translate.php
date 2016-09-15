<?php

use wcf\data\package\update\server\PackageUpdateServerAction;
use wcf\system\WCF;

$package = $this->installation->getPackage();

// set default page title
if (!defined('PAGE_TITLE') || !PAGE_TITLE) {
	$sql = "UPDATE	wcf".WCF_N."_option
		SET	optionValue = ?
		WHERE	optionName = ?";
	$statement = WCF::getDB()->prepareStatement($sql);
	$statement->execute(array('Community Translation Center', 'page_title'));
}

// add mysterycode update server
if (isset($this->instruction['attributes']['installupdateserver']) && $this->instruction['attributes']['installupdateserver'] == 1) {
	$serverURL = 'http://update.mysterycode.de/vortex/';

	// check if update server already exists
	$sql = "SELECT	packageUpdateServerID
		FROM	wcf".WCF_N."_package_update_server
		WHERE	serverURL = ?";
	$statement = WCF::getDB()->prepareStatement($sql);
	$statement->execute(array($serverURL));
	$row = $statement->fetchArray();
	if ($row === false) {
		$objectAction = new PackageUpdateServerAction([], 'create', array('data' => array(
			'serverURL' => $serverURL
		)));
		$objectAction->executeAction();
	}
}
