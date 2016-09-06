<?php

namespace wcf\system\page\handler;
use translate\data\language\item\LanguageItem;
use translate\system\cache\runtime\LanguageItemRuntimeCache;
use wcf\data\page\Page;
use wcf\data\user\online\UserOnline;
use wcf\system\WCF;

class LanguageItemPageHandler extends AbstractMenuPageHandler implements IOnlineLocationPageHandler {
	use TOnlineLocationPageHandler;
	
	/**
	 * @inheritDoc
	 */
	public function getOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID === null) {
			return '';
		}
		
		$item = new LanguageItem($user->pageObjectID);
		if ($item === null)
			return '';
		
		return WCF::getLanguage()->getDynamicVariable('wcf.page.onlineLocation.'.$page->identifier, ['item' => $item]);
	}
	
	/**
	 * @inheritDoc
	 */
	public function prepareOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID !== null) {
			LanguageItemRuntimeCache::getInstance()->cacheObjectID($user->pageObjectID);
		}
	}
}
