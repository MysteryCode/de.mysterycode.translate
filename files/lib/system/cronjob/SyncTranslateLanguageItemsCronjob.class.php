<?php

namespace translate\system\cronjob;
use wcf\data\cronjob\Cronjob;

class SyncTranslateLanguageItemsCronjob extends ´SyncWCFLanguageItemsCronjob {
	public $languageFileFolder = '';
	
	public $packageName = 'de.mysterycode.translate';
	
	protected function fixFolderPath() {
		// yep, it's a specific path
		$this->languageFileFolder = str_replace('translate.mysterycode.de', '', WCF_DIR) . 'git/translate-master/language/';
	}
}
