<?php

namespace translate\system\cache\runtime;
use translate\data\package\PackageList;

class PackageRuntimeCache extends AbstractRuntimeCache {
	/**
	 * @inheritDoc
	 */
	protected $listClassName = PackageList::class;
}
