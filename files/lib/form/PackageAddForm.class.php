<?php

namespace translate\form;
use translate\data\package\PackageAction;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class PackageAddForm extends AbstractForm {
	/**
	 * @see \wcf\acp\form\AbstractForm::$activeMenuItem
	 */
	public $activeMenuItem = 'translate.menu.link.package';
	
	/**
	 * @see \wcf\acp\form\AbstractForm::$neededPermissions
	 */
	public $neededPermissions = [];
	
	/**
	 * package object
	 * @var	\translate\data\package\Package
	 */
	public $package = null;
	
	/**
	 * package id
	 * @var	integer
	 */
	public $packageID = 0;
	
	/**
	 * package identifier
	 * @var string
	 */
	public $identifier = '';
	
	/**
	 * package title
	 * @var string
	 */
	public $title = '';
	
	/**
	 * desription of the package
	 * @var string
	 */
	public $description = '';
	
	/**
	 * package is an standalone application
	 * @var string
	 */
	public $application = false;
	
	/**
	 * package can be installed once only (tempest)
	 * @var string
	 */
	public $isunique = false;
	
	/**
	 * pacakge is a plugin for this (tempest)
	 * @var string
	 */
	public $plugin = '';
	
	/**
	 * name of the author
	 * @var string
	 */
	public $author = '';
	
	/**
	 * author's website
	 * @var string
	 */
	public $authorUrl = '';
	
	/**
	 * author's support forum/bugtracker/whatever
	 * @var string
	 */
	public $supportUrl = '';
	
	/**
	 * clone url of github
	 * @var string
	 */
	public $github = '';
	
	/**
	 * @inheritDoc
	 */
	public function readFormParameters() {
		parent::readFormParameters();

		if (!empty($_POST['identifier'])) $this->identifier = StringUtil::trim($_POST['identifier']);
		if (!empty($_POST['title'])) $this->title = StringUtil::trim($_POST['title']);
		if (!empty($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
		if (!empty($_POST['application'])) $this->application = true;
		if (!empty($_POST['isunique'])) $this->isunique = true;
		if (!empty($_POST['plugin'])) $this->plugin = StringUtil::trim($_POST['plugin']);
		if (!empty($_POST['author'])) $this->author = StringUtil::trim($_POST['author']);
		if (!empty($_POST['authorUrl'])) $this->authorUrl = StringUtil::trim($_POST['authorUrl']);
		if (!empty($_POST['supportUrl'])) $this->supportUrl = StringUtil::trim($_POST['supportUrl']);
		if (!empty($_POST['github'])) $this->github = StringUtil::trim($_POST['github']);
	}
	
	/**
	 * @inheritDoc
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->identifier))
			throw new UserInputException('identifier');
		
		if (empty($this->title))
			throw new UserInputException('title');
	}
	
	/**
	 * @inheritDoc
	 */
	public function save() {
		parent::save();
		
		$data = [
			'data' => [
				'identifier' => $this->identifier,
				'title' => $this->title,
				'description' => $this->description,
				'application' => $this->application,
				'isuniquie' => $this->isunique,
				'plugin' => $this->plugin,
				'author' => $this->author,
				'authorUrl' => $this->authorUrl,
				'supportUrl' => $this->supportUrl,
				'github' => $this->github
			]
		];
		
		$this->objectAction = new PackageAction([], 'create', $data);
		$this->objectAction->executeAction();
		
		$this->saved();
		
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @inheritDoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'package' => $this->package,
			'packageID' => $this->packageID,
			
			'identifier' => $this->identifier,
			'title' => $this->title,
			'description' => $this->description,
			'application' => $this->application,
			'isuniquie' => $this->isunique,
			'plugin' => $this->plugin,
			'author' => $this->author,
			'authorUrl' => $this->authorUrl,
			'supportUrl' => $this->supportUrl,
			'github' => $this->github
		]);
	}
}
