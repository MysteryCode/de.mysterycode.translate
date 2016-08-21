<?php

namespace translate\util;
use wcf\util\XML;

class LanguageFileReaderUtil {
	public static function parseXML($content = '') {
// 		$categoryList = [];
		$itemList = [];
		
		$xml = new XML();
		$xml->loadXML('language.xml', $content);
		$xpath = $xml->xpath();
		
		$categories = $xpath->query('/ns:section/ns:category');
		foreach ($categories as $category) {
// 			$categoryList[$category->getAttribute('name')] = $category->nodeValue;
			
			$items = $xpath->query('./ns:item/*', $package);
			foreach ($items as $item) {
				$itemList[$category->getAttribute('name')][$item->getAttribute('name')] = $item->nodeValue;
			}
		}
		
		return $itemList;
	}
}
