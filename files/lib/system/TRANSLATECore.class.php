<?php

namespace translate\system;
use wcf\system\application\AbstractApplication;

class TRANSLATECore extends AbstractApplication {
	/**
	 * @see	wcf\system\application\AbstractApplication::$abbreviation
	 */
	protected $abbreviation = 'translate';
	
	/**
	 * @see \wcf\system\application\AbstractApplication::$primaryController
	 */
	protected $primaryController = 'translate\page\LanguageItemPage';
}
