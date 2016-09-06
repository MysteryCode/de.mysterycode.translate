<?php

namespace translate\system\cronjob;
use translate\data\language\LanguageList;
use translate\data\package\PackageList;
use translate\util\LanguageFileReaderUtil;
use wcf\data\cronjob\Cronjob;
use wcf\system\cronjob\AbstractCronjob;
use wcf\system\exception\SystemException;
use wcf\util\HTTPRequest;

class GitHubFetchCronjob extends AbstractCronjob {
	public function execute(Cronjob $cronjob) {
		parent::execute($cronjob);
		
		$packageList = new PackageList();
		$packageList->getConditionBuilder()->add('github IS NOT NULL');
		$packageList->readObjects();
		$packages = $packageList->getObjects();
		
		$languageList = new LanguageList();
		$languageList->readObjects();
		$languages = $languageList->getObjects();
		
		foreach ($packages as $package) {
			foreach ($languages as $language) {
				$url = $package->github . 'languages/' . $language->lsnguageCode . '.xml';
				$request = new HTTPRequest($url);
				try {
					$reply = $request->getReply();
				}
				catch (SystemException $e) {
					//TODO
				}
				
				$content = $reply['body'];
				
				$languageArray = LanguageFileReaderUtil::parseXML($content);
				
				WCF::getDB()->beginTransaction();
				//TODO
				WCF::getDB()->commitTransaction();
			}
		}
	}
}
