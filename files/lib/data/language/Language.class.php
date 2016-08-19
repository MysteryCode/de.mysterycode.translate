<?php

namespace translate\data\language;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

class Language extends DatabaseObject {
	public function getTitle() {
		return  WCF::getLanguage()->get($this->languageName);
	}
}
