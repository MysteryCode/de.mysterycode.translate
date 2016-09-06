<?php

namespace translate\system\cache\runtime;
use translate\data\language\LanguageList;

class LanguageRuntimeCache extends AbstractRuntimeCache {
	/**
	 * @inheritDoc
	 */
	protected $listClassName = LanguageList::class;
}
