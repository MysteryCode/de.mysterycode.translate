<?php

namespace translate\data\language\item;
use wcf\data\search\ISearchResultObject;
use wcf\data\user\User;
use wcf\data\user\UserProfile;
use wcf\system\request\LinkHandler;

class SearchResultLanguageItem extends LanguageItem implements ISearchResultObject {
	/**
	 * @inheritDoc
	 */
	public function getUserProfile() {
		return new UserProfile(new User($this->getPackage()->userID));
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
		
		return LinkHandler::getInstance()->getLink('LanguageItem', $parameters);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getObjectTypeName() {
		return 'de.mysterycode.tanslate.language.item';
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
