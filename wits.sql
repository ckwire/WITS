/* SQL FILE TO CREATE NECESSARY TABLES FOR DATABASE. */

/* CREATE TABLE: members */
/* NOTE: any user passwords need to be encrypted */
CREATE TABLE `members` (
 `id` char(23) NOT NULL,
 `fname` varchar(15) NOT NULL,
 `username` varchar(65) NOT NULL DEFAULT '',
 `password` varchar(65) NOT NULL DEFAULT '',
 `email` varchar(65) NOT NULL,
 `verified` tinyint(1) NOT NULL DEFAULT '0',
 `mod_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username_UNIQUE` (`username`),
 UNIQUE KEY `id_UNIQUE` (`id`),
 UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* INSERT INTO TABLE member */
/* User Details!!! Username: demo, Password: 123456 */
INSERT INTO `members` (`id`, `fname`, `username`, `password`, `email`, `verified`, `mod_timestamp`) VALUES ('6400902959c45c4a60b90', 'Demo', 'demo', '$2y$10$qv0fYPpFVQRQRrf1hb7D6uTTiSrkt3foGCLQtN9b2ur.XAej4x4iq', 'demo@demo.com', '1', CURRENT_TIMESTAMP);

/* CREATE TABLE: loginAttempts */
CREATE TABLE `loginAttempts` (
 `IP` varchar(20) NOT NULL,
 `Attempts` int(11) NOT NULL,
 `LastLogin` datetime NOT NULL,
 `Username` varchar(65) DEFAULT NULL,
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/* CREATES TABLE: int_status */
CREATE TABLE `inv_status` ( `statusID` INT NOT NULL , `statusDescription` VARCHAR(8) NOT NULL , PRIMARY KEY (`statusID`)) ENGINE = InnoDB;

/* FILL TABLE: int_status */
INSERT INTO `inv_status` (`statusID`, `statusDescription`) VALUES ('1', 'Active');
INSERT INTO `inv_status` (`statusID`, `statusDescription`) VALUES ('2', 'Inactive');
INSERT INTO `inv_status` (`statusID`, `statusDescription`) VALUES ('3', 'Pending');


/* CREATES TABLE: inv_inventory */
CREATE TABLE `inv_inventory` (
  `inventoryID` int(11) NOT NULL COMMENT 'UPC',
  `inventoryName` varchar(20) NOT NULL,
  `inventoryDescription` varchar(50) NOT NULL,
  `inventoryCost` decimal(15,2) NOT NULL,
  `inventoryUnit` int(11) NOT NULL,
  `inventoryPrice` decimal(15,2) NOT NULL,
  `inventoryStatus` int(11) NOT NULL,
  `inventoryFirstDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`inventoryID`),
  KEY `inventoryStatus` (`inventoryStatus`),
  CONSTRAINT `fk_inventoryStatus` FOREIGN KEY (`inventoryStatus`) REFERENCES `inv_status` (`statusID`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/* CREATES TABLE: inv_locations*/
CREATE TABLE `inv_locations` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `locationName` varchar(20) NOT NULL,
  `locationStatus` int(11) NOT NULL,
  `locationNotes` varchar(50) NOT NULL,
  `locationAddress` varchar(30) NOT NULL,
  `locationCity` varchar(20) NOT NULL,
  `locationState` varchar(2) NOT NULL,
  `locationZIP` int(11) NOT NULL,
  PRIMARY KEY (`locationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* ALTER TABLE: inv_location > adds FK to inv_status */
ALTER TABLE inv_locations
	ADD CONSTRAINT fk_locationStatus
    FOREIGN KEY fk_locationStatus(locationStatus)
    REFERENCES inv_status(statusID)
    ON UPDATE RESTRICT
    ON DELETE NO ACTION;
    
/* FILL TABLE: int_locations */
INSERT INTO `inv_locations` (`locationID`, `locationName`, `locationStatus`, `locationNotes`, `locationAddress`, `locationCity`, `locationState`, `locationZIP`) VALUES (NULL, 'Kalamazoo', '1', 'Kalamazoo Location', '5360 9th St.', 'Kalamazoo', 'MI', '49009');
INSERT INTO `inv_locations` (`locationID`, `locationName`, `locationStatus`, `locationNotes`, `locationAddress`, `locationCity`, `locationState`, `locationZIP`) VALUES (NULL, 'Grand Rapids SW', '1', 'Grand Rapids Southwest Location', '5656 Clyde Park Ave SW', 'Wyoming', 'MI', '49509');
INSERT INTO `inv_locations` (`locationID`, `locationName`, `locationStatus`, `locationNotes`, `locationAddress`, `locationCity`, `locationState`, `locationZIP`) VALUES (NULL, 'Grand Rapids NE', '3', 'Grand Rapids Northeast Location', '5050 West River Dr. NE', 'Comstock Park, MI', 'MI', '49321');
INSERT INTO `inv_locations` (`locationID`, `locationName`, `locationStatus`, `locationNotes`, `locationAddress`, `locationCity`, `locationState`, `locationZIP`) VALUES (NULL, 'Battle Creek', '1', 'Battle Creek Location', '6330 B Dr. N', 'Battle Creek', 'MI', '49014');
INSERT INTO `inv_locations` (`locationID`, `locationName`, `locationStatus`, `locationNotes`, `locationAddress`, `locationCity`, `locationState`, `locationZIP`) VALUES (NULL, 'Lansing', '1', 'Lansing Location', '8114 W Saginaw Hwy', 'Lansing', 'MI', '48917');

