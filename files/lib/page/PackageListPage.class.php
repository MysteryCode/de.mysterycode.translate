<?php

namespace translate\page;
use translate\data\package\PackageList;
use wcf\page\SortablePage;
use wcf\system\WCF;

class PackageListPage extends SortablePage {
	/**
	 * @see \wcf\page\SortablePage::$defaultSortField
	 */
	public $defaultSortField = 'title';
	
	/**
	 * @see \wcf\page\SortablePage::$validSortFields
	 */
	public $validSortFields = ['packageID', 'title', 'identifier', 'author', 'variables', 'checkedVariables'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = PackageList::class;
}
