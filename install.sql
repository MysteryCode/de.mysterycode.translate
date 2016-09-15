DROP TABLE IF EXISTS translate1_package;
CREATE TABLE translate1_package (
	packageID					INT(10)			NOT NULL	AUTO_INCREMENT,
	identifier					VARCHAR(255)	NOT NULL	DEFAULT '',
	title						VARCHAR(255)	NOT NULL,
	description					TEXT			NOT NULL,
	application					TINYINT(1)		NOT NULL	DEFAULT 0,
	isunique					TINYINT(1)		NOT NULL	DEFAULT 0,
	plugin						VARCHAR(255)	NOT NULL	DEFAULT '',
	author						VARCHAR(255)	NOT NULL,
	authorUrl					VARCHAR(255)	NOT NULL,
	supportUrl					VARCHAR(255)	NOT NULL,
	github						VARCHAR(255),
	variables					INT(10)			NOT NULL	DEFAULT 0,
	variablesChecked			INT(10)			NOT NULL	DEFAULT 0,
	PRIMARY KEY (packageID),
	KEY (identifier)
);

DROP TABLE IF EXISTS translate1_package_version;
CREATE TABLE translate1_package_version (
	versionID					INT(10)			NOT NULL	AUTO_INCREMENT,
	packageID					INT(10)			NOT NULL,
	userID						INT(10),
	username					VARCHAR(255)	NOT NULL	DEFAULT '',
	version						VARCHAR(255)	NOT NULL	DEFAULT '',
	codename					VARCHAR(255)	NOT NULL	DEFAULT '',
	time						INT(10)			NOT NULL	DEFAULT 0,
	license						VARCHAR(255)	NOT NULL	DEFAULT '',
	licenseUrl					VARCHAR(255)	NOT NULL,
	excludedPackages			TEXT			NOT NULL,
	requiredPackages			TEXT			NOT NULL,
	optionals					TEXT			NOT NULL,
	updateFrom					TEXT			NOT NULL,
	active						TINYINT(1)		NOT NULL	DEFAULT 0,
	filename					VARCHAR(255)	NOT NULL	DEFAULT '',
	filesize					VARCHAR(255)	NOT NULL	DEFAULT '',
	tmpHash						CHAR(40)		NOT NULL	DEFAULT '',
	mimeType					VARCHAR(255)	NOT NULL	DEFAULT '',
	PRIMARY KEY (versionID),
	KEY (packageID)
);

DROP TABLE IF EXISTS translate1_language;
CREATE TABLE translate1_language (
	languageID					INT(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageCode				VARCHAR(20)		NOT NULL	DEFAULT '',
	languageName				VARCHAR(255)	NOT NULL	DEFAULT '',
	foreignLanguageName			VARCHAR(255)	NOT NULL	DEFAULT '',
	countryCode					VARCHAR(10)		NOT NULL	DEFAULT '',
	isDisabled					TINYINT(1)		NOT NULL	DEFAULT 0,
	UNIQUE KEY languageCode (languageCode)
);

DROP TABLE IF EXISTS translate1_language_category;
CREATE TABLE translate1_language_category (
	languageCategoryID			INT(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageCategory			VARCHAR(191)	NOT NULL	DEFAULT '',
	UNIQUE KEY languageCategory (languageCategory)
);

DROP TABLE IF EXISTS translate1_language_item;
CREATE TABLE translate1_language_item (
	languageItemID				INT(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageItem				VARCHAR(191)	NOT NULL	DEFAULT '',
	languageCategoryID			INT(10)			NOT NULL,
	packageID					INT(10),
	UNIQUE KEY languageItem (languageItem)
);

DROP TABLE IF EXISTS translate1_language_item_value;
CREATE TABLE translate1_language_item_value (
	languageItemValueID			INT(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageID					INT(10)			NOT NULL,
	languageItemID				INT(10)			NOT NULL,
	languageItemValue			MEDIUMTEXT		NOT NULL,
	checked						TINYINT(1)		NOT NULL	DEFAULT 0,
	UNIQUE KEY languageItem (languageID, languageItemID)
);

DROP TABLE IF EXISTS translate1_language_item_check;
CREATE TABLE translate1_language_item_check (
	languageItemCheckID			INT(10)			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	languageItemID				INT(10)			NOT NULL,
	languageItemValueID			INT(10)			NOT NULL,
	userID						INT(10),
	username					VARCHAR(255)	NOT NULL	DEFAULT '',
	time						INT(10)			NOT NULL	DEFAULT 0,
	ipAddress					VARCHAR(39)		NOT NULL	DEFAULT '',
	UNIQUE KEY languageItem (username, languageItemID)
);

ALTER TABLE translate1_package_version ADD FOREIGN KEY (packageID) REFERENCES translate1_package (packageID) ON DELETE CASCADE;
ALTER TABLE translate1_package_version ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;

ALTER TABLE translate1_language_item ADD FOREIGN KEY (languageCategoryID) REFERENCES translate1_language_category (languageCategoryID) ON DELETE CASCADE;
ALTER TABLE translate1_language_item ADD FOREIGN KEY (packageID) REFERENCES translate1_package (packageID) ON DELETE SET NULL;

ALTER TABLE translate1_language_item_value ADD FOREIGN KEY (languageID) REFERENCES translate1_language (languageID) ON DELETE CASCADE;
ALTER TABLE translate1_language_item_value ADD FOREIGN KEY (languageItemID) REFERENCES translate1_language_item (languageItemID) ON DELETE CASCADE;

ALTER TABLE translate1_language_item_check ADD FOREIGN KEY (languageItemID) REFERENCES translate1_language_item (languageItemID) ON DELETE CASCADE;
ALTER TABLE translate1_language_item_check ADD FOREIGN KEY (languageItemValueID) REFERENCES translate1_language_item_value (languageItemValueID) ON DELETE CASCADE;
ALTER TABLE translate1_language_item_check ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
