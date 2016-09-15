<?php

namespace translate\data\language;
use translate\data\I18nDatabaseObjectList;

class LanguageList extends I18nDatabaseObjectList {
	/**
	 * @inheritDoc
	 */
	public $i18nFields = [ 'languageName' ];
}
