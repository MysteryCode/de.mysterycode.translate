<?php

namespace translate\system\event\listener;
use wcf\system\event\listener\IParameterizedEventListener;
use wcf\system\WCF;

class UserRenameListener implements IParameterizedEventListener {
	/**
	 * @see \wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		$objects = $eventObj->getObjects();
		$userID = $objects[0]->userID;
		$parameters = $eventObj->getParameters();
		$username = $parameters['data']['username'];
		
		$sql = array();
		// package versions
		$sql[] = "UPDATE		translate" . WCF_N . "_package_version
			SET		username = ?
			WHERE		userID = ?";
		// item checks
		$sql[] = "UPDATE		translate" . WCF_N . "_language_item_check
			SET		username = ?
			WHERE		userID = ?";
		
		foreach ($sql as $query) {
			$statement = WCF::getDB()->prepareStatement($query);
			$statement->execute(array($username, $userID));
		}
	}
}
