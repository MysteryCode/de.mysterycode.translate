<?php

namespace translate\data\package\version;
use wcf\data\DatabaseObjectEditor;

class PackageVersionEditor extends DatabaseObjectEditor {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'translate\data\package\version\PackageVersion';
}
