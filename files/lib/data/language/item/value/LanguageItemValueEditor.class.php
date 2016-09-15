<?php

namespace translate\data\language\item\value;
use translate\data\language\item\value\LanguageItemValue;
use wcf\data\DatabaseObjectEditor;

class LanguageItemValueEditor extends DatabaseObjectEditor {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = LanguageItemValue::class;
}
