CREATE TABLE `Click` (
	`id` int AUTO_INCREMENT NOT NULL,
	`id_IP` int NOT NULL,
	`userAgent` varchar(255) NOT NULL,
	`width_screen` int NOT NULL,
	`height_screen` int NOT NULL,
	`city` varchar(255) NOT NULL,
	`region` varchar(255) NOT NULL,
	`country` varchar(255) NOT NULL,
	`platform` varchar(255) NOT NULL,
	`time_in` TIMESTAMP NOT NULL,
	`time_out` TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `IP` (
	`id` int AUTO_INCREMENT NOT NULL,
	`IP` varchar(16) NOT NULL,
	`isBad` bool NOT NULL DEFAULT false,
	`points` int NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE `User` (
	`id` int AUTO_INCREMENT NOT NULL,
	`login` varchar(500) NOT NULL,
	`password` varchar(500) NOT NULL,
	`K_min` int NOT NULL,
	`N_sec` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Region` (
	`id` int AUTO_INCREMENT NOT NULL,
	`name` varchar(500) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `User_Region` (
	`id_User` int NOT NULL,
	`id_Region` int NOT NULL
);

ALTER TABLE `Click` ADD CONSTRAINT `Click_fk0` FOREIGN KEY (`id_IP`) REFERENCES `IP`(`id`);

ALTER TABLE `User_Region` ADD CONSTRAINT `User_Region_fk0` FOREIGN KEY (`id_User`) REFERENCES `User`(`id`);

ALTER TABLE `User_Region` ADD CONSTRAINT `User_Region_fk1` FOREIGN KEY (`id_Region`) REFERENCES `Region`(`id`);
