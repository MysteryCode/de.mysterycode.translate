<?php

namespace translate\page;
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
	public $validSortFields = ['title', 'identifier', 'author', 'variables', 'checkedVariables'];
	
	/**
	 * @see \wcf\page\MultipleLinkPage::$objectListClassname
	 */
	public $objectListClassName = 'translate\\data\\package\\PackageList';
}
