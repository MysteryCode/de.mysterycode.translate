<?php

namespace translate\util;
use wcf\util\XML;

class LanguageFileReaderUtil {
	public static function parseXML ($content = '') {
		$itemList = [];
		
		$xml = new XML();
		$xml->loadXML('language.xml', $content);
		$xpath = $xml->xpath();
		
		$categories = $xpath->query('/ns:language/ns:category');
		foreach ($categories as $category) {
			$items = $xpath->query('child::*', $category);
			foreach ($items as $item) {
				$itemList[$category->getAttribute('name')][$item->getAttribute('name')] = $item->nodeValue;
			}
		}
		
		return $itemList;
	}
}
