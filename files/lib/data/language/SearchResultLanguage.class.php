<?php

namespace translate\data\language;
use wcf\data\search\ISearchResultObject;
use wcf\data\user\User;
use wcf\data\user\UserProfile;
use wcf\system\request\LinkHandler;

class SearchResultLanguage extends Language implements ISearchResultObject {
	/**
	 * @inheritDoc
	 */
	public function getUserProfile() {
		return null;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getSubject() {
		return $this->getTitle();
	}
	
	/**
	 * @inheritDoc
	 */
	public function getTime() {
		return 0;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getLink($query = '') {
		$parameters = [
			'application' => 'translate',
			'object' => $this,
			'forceFrontend' => true
		];
		
		if ($query) {
			$parameters['highlight'] = urlencode($query);
		}
		
		return LinkHandler::getInstance()->getLink('Language', $parameters);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getObjectTypeName() {
		return 'de.mysterycode.tanslate.language';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getFormattedMessage() {
		return '';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getContainerTitle() {
		return '';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getContainerLink() {
		return '';
	}
}
