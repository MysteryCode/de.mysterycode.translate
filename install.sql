DROP TABLE IF EXISTS translate1_package;
CREATE TABLE translate1_package (
	packageID					int(10)			NOT NULL	AUTO_INCREMENT,
	identifier					varchar(255)	NOT NULL	DEFAULT '',
	title						varchar(255)	NOT NULL,
	description					text			NOT NULL,
	application					tinyint(1)		NOT NULL	DEFAULT 0,
	isunique					tinyint(1)		NOT NULL	DEFAULT 0,
	plugin						varchar(255)	NOT NULL	DEFAULT '',
	author						varchar(255)	NOT NULL,
	authorUrl					varchar(255)	NOT NULL,
	supportUrl					varchar(255)	NOT NULL,
	PRIMARY KEY (packageID)
);

DROP TABLE IF EXISTS translate1_package_version;
CREATE TABLE translate1_package_version (
	versionID					int(10)			NOT NULL	AUTO_INCREMENT,
	packageID					int(10)			NOT NULL,
	userID						int(10),
	username					varchar(255)	NOT NULL	DEFAULT '',
	version						varchar(255)	NOT NULL	DEFAULT '',
	codename					varchar(255)	NOT NULL	DEFAULT '',
	time						int(10)			NOT NULL	DEFAULT 0,
	license						varchar(255)	NOT NULL	DEFAULT '',
	licenseUrl					varchar(255)	NOT NULL,
	excludedPackages			text			NOT NULL,
	requiredPackages			text			NOT NULL,
	optionals					text			NOT NULL,
	updateFrom					text			NOT NULL,
	active						tinyint(1)		NOT NULL	DEFAULT 0,
	filename					varchar(255)	NOT NULL	DEFAULT '',
	filesize					varchar(255)	NOT NULL	DEFAULT '',
	tmpHash						varchar(40)		NOT NULL	DEFAULT '',
	mimeType					varchar(255)	NOT NULL	DEFAULT '',
	PRIMARY KEY (versionID)
);

DROP TABLE IF EXISTS translate1_language;
CREATE TABLE translate1_language (
	languageID					int(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageCode				varchar(20)		NOT NULL	DEFAULT '',
	languageName				varchar(255)	NOT NULL	DEFAULT '',
	foreignLanguageName			varchar(255)	NOT NULL	DEFAULT '',
	countryCode					varchar(10)		NOT NULL	DEFAULT '',
	isDisabled					tinyint(1)		NOT NULL	DEFAULT 0,
	UNIQUE KEY languageCode (languageCode)
);

DROP TABLE IF EXISTS translate1_language_category;
CREATE TABLE translate1_language_category (
	languageCategoryID			int(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageCategory			varchar(191)	NOT NULL	DEFAULT '',
	UNIQUE KEY languageCategory (languageCategory)
);

DROP TABLE IF EXISTS translate1_language_item;
CREATE TABLE translate1_language_item (
	languageItemID				int(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageID					int(10)			NOT NULL,
	languageItem				varchar(191)	NOT NULL	DEFAULT '',
	languageItemValue			mediumtext		NOT NULL,
	languageCategoryID			int(10)			NOT NULL,
	checked						tinyint(1)		NOT NULL	DEFAULT 0,
	checkedByUserIDs			mediumtext,
	packageID					int(10),
	UNIQUE KEY languageItem (languageItem, languageID)
);


ALTER TABLE translate1_package_version ADD FOREIGN KEY (packageID) REFERENCES translate1_package (packageID) ON DELETE CASCADE;
ALTER TABLE translate1_package_version ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;

ALTER TABLE translate1_language_item ADD FOREIGN KEY (languageID) REFERENCES translate1_language (languageID) ON DELETE CASCADE;
ALTER TABLE translate1_language_item ADD FOREIGN KEY (languageCategoryID) REFERENCES translate1_language_category (languageCategoryID) ON DELETE CASCADE;
