<?php

namespace translate\system\cache\runtime;
use translate\data\language\item\LanguageItemList;

class LanguageItemRuntimeCache extends AbstractRuntimeCache {
	/**
	 * @inheritDoc
	 */
	protected $listClassName = LanguageItemList::class;
}
