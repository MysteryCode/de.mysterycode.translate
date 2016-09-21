<?php

namespace translate\data\package;
use wcf\data\search\ISearchResultObject;
use wcf\data\user\User;
use wcf\data\user\UserProfile;
use wcf\system\request\LinkHandler;
use wcf\system\search\SearchResultTextParser;

class SearchResultPackage extends Package implements ISearchResultObject {
	/**
	 * @inheritDoc
	 */
	public function getUserProfile() {
		return new UserProfile(new User($this->userID));
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
		
		return LinkHandler::getInstance()->getLink('Package', $parameters);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getObjectTypeName() {
		return 'de.mysterycode.tanslate.package';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getFormattedMessage() {
		return SearchResultTextParser::getInstance()->parse($this->description);
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
