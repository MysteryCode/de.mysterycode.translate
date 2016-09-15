<?php

namespace translate\data\package;
use translate\data\I18nDatabaseObjectList;

class PackageList extends I18nDatabaseObjectList {
	/**
	 * @inheritDoc
	 */
	public $i18nFields = [ 'title' ];
}
