<?php

namespace translate\system\page\handler;
use translate\data\package\Package;
use translate\system\cache\runtime\PackageRuntimeCache;
use wcf\data\page\Page;
use wcf\data\user\online\UserOnline;
use wcf\system\WCF;

class PackagePageHandler extends AbstractMenuPageHandler implements IOnlineLocationPageHandler {
	use TOnlineLocationPageHandler;
	
	/**
	 * @inheritDoc
	 */
	public function getOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID === null) {
			return '';
		}
		
		$package = new Package($user->pageObjectID);
		if ($package === null)
			return '';
		
		return WCF::getLanguage()->getDynamicVariable('wcf.page.onlineLocation.'.$page->identifier, ['package' => $package]);
	}
	
	/**
	 * @inheritDoc
	 */
	public function prepareOnlineLocation(Page $page, UserOnline $user) {
		if ($user->pageObjectID !== null) {
			PackageRuntimeCache::getInstance()->cacheObjectID($user->pageObjectID);
		}
	}
}
