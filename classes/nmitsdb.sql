USE nmitsdb;


/*USE kgisuydd_nmitsdb;*/

CREATE TABLE IF NOT EXISTS usertab (
		 userid 	INT UNSIGNED 	NOT NULL AUTO_INCREMENT,
		 surname 	VARCHAR(45)		NOT NULL,
		 firstname 	VARCHAR(45)		NOT NULL,
		 dateofreg 	DATE			NOT NULL,
		 phone 		VARCHAR(45)		NOT NULL,
		 email 		VARCHAR(45) 	NOT NULL UNIQUE,
		 password 	VARCHAR(45)		NOT NULL,
		 role 		VARCHAR(45)		NOT NULL,
		 category 	VARCHAR(45),
		 CONSTRAINT PK_usertab PRIMARY KEY (userid)
		 )ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS loginstamptab (
		loginid 	BIGINT UNSIGNED 	NOT NULL AUTO_INCREMENT,
		userid 		INT UNSIGNED 		NOT NULL,
		logintime 	DATETIME			NOT NULL,
		logouttime 	DATETIME			NOT NULL,
		CONSTRAINT PK_loginstamptab PRIMARY KEY (loginid),
		CONSTRAINT FK_loginstamptab_userid FOREIGN KEY (userid)
		REFERENCES usertab(userid)
		ON UPDATE CASCADE ON DELETE RESTRICT
		)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS moduletab(
		moduleid 		INT UNSIGNED 	NOT NULL AUTO_INCREMENT,
		moduleno		INT UNSIGNED 	NOT NULL UNIQUE,
		moduletopic 	VARCHAR(255) 	NOT NULL,
		objective 		VARCHAR(255),
		prerequisite 	VARCHAR(255),
		hours 			VARCHAR(45) 	NOT NULL,
		category 		VARCHAR(45) 	NOT NULL,
		CONSTRAINT PK_moduletab PRIMARY KEY (moduleid)
		)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS testtab(
			testid 		INT UNSIGNED 	NOT NULL AUTO_INCREMENT,
			testno		INT UNSIGNED	NOT NULL,
			moduleid 	INT UNSIGNED 	NOT NULL,
			hours 		DECIMAL(3) 		NOT NULL,
			question 	VARCHAR(450) 	NOT NULL,
			answer1 	VARCHAR(255) 	NOT NULL,
			answer2 	VARCHAR(255) 	NOT NULL,
			answer3 	VARCHAR(255) 	NOT NULL,
			answer4 	VARCHAR(255) 	NOT NULL,
			answer5 	VARCHAR(255) 	NOT NULL,
			canswer 	CHAR(1) 		NOT NULL,
			CONSTRAINT PK_testtab PRIMARY KEY (testid),
			)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS progresstab (
			progressid 	INT UNSIGNED 	NOT NULL AUTO_INCREMENT,
			userid 		INT 			NOT NULL,
			moduleid 	INT 			NOT NULL,
			testid 		INT 			NOT NULL,
			score 		INT 			NOT NULL,
			grade 		CHAR(1) 		NOT NULL,
			remark 		VARCHAR(10) 	NOT NULL,
			timing 		DATETIME 		NOT NULL,
			PRIMARY KEY (progressid)
			)ENGINE=InnoDB;
