<?php

namespace translate\form;
use translate\data\package\PackageAction;
use translate\data\package\PackageCache;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class PackageEditForm extends PackageAddForm {
	/**
	 * @inheritDoc
	 */
	public $neededPermissions = [];
	
	/**
	 * @inheritDoc
	 */
	public function readParameters() {
		parent::readParameters();

		if (!empty($_REQUEST['id'])) $this->packageID = intval($_REQUEST['id']);
		
		$this->package = PackageCache::getInstance()->getPackage($this->packageID);
		if ($this->package === null)
			throw new IllegalLinkException();
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
				'isunique' => $this->isunique,
				'plugin' => $this->plugin,
				'author' => $this->author,
				'authorUrl' => $this->authorUrl,
				'supportUrl' => $this->supportUrl,
				'github' => $this->github
			]
		];
		
		$this->objectAction = new PackageAction([ $this->package ], 'update', $data);
		$this->objectAction->executeAction();
		
		$this->saved();
		
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see \wcf\acp\form\AbstractForm::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			$this->identifier = $this->package->identifier;
			$this->title = $this->package->title;
			$this->description = $this->package->description;
			$this->application = $this->package->application;
			$this->isunique = $this->package->isunique;
			$this->plugin = $this->package->plugin;
			$this->author = $this->package->author;
			$this->authorUrl = $this->package->authorUrl;
			$this->supportUrl = $this->package->supportUrl;
			$this->github = $this->package->github;
		}
	}
}
