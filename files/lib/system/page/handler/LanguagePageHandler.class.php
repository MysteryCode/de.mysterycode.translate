<?php

namespace wcf\system\page\handler;
use translate\data\language\Language;
use translate\system\cache\runtime\LanguageRuntimeCache;
use wcf\data\page\Page;
use wcf\data\user\online\UserOnline;
use wcf\system\WCF;

class LanguagePageHandler extends AbstractMenuPageHandler implements IOnlineLocationPageHandler {
	use TOnlineLocationPageHandler;
	
	/**
	 * @inheritDoc
	 */
	public function getOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID === null) {
			return '';
		}
		
		$language = new Language($user->pageObjectID);
		if ($language === null)
			return '';
		
		return WCF::getLanguage()->getDynamicVariable('wcf.page.onlineLocation.'.$page->identifier, ['language' => $language]);
	}
	
	/**
	 * @inheritDoc
	 */
	public function prepareOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID !== null) {
			LanguageRuntimeCache::getInstance()->cacheObjectID($user->pageObjectID);
		}
	}
}
