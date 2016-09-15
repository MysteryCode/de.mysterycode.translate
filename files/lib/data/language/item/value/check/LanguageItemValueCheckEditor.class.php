<?php

namespace translate\data\language\item\value\check;
use translate\data\language\item\value\check\LanguageItemValueCheck;
use wcf\data\DatabaseObjectEditor;

class LanguageItemValueCheckEditor extends DatabaseObjectEditor {
	/**
	 * @see \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = LanguageItemValueCheck::class;
}
