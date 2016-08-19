<?php

namespace translate\data\language;
use wcf\data\DatabaseObjectEditor;

class LanguageEditor extends DatabaseObjectEditor {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'translate\data\language\Language';
}
