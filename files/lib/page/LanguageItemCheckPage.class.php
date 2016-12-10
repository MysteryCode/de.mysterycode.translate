<?php

namespace translate\page;
use wcf\page\AbstractPage;

class LanguageItemCheckPage extends AbstractPage {
	/**
	 * @see \wcf\acp\form\AbstractForm::$neededPermissions
	 */
	public $neededPermissions = [ 'user.translate.language.item.canCheck' ];
}
