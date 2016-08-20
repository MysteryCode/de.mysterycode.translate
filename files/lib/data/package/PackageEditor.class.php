<?php

namespace translate\data\package;
use wcf\data\DatabaseObjectEditor;

class PackageEditor extends DatabaseObjectEditor {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'translate\data\package\Package';
}
