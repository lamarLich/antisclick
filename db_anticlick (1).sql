CREATE TABLE `click` (
	`id` int NOT NULL AUTO_INCREMENT,
	`id_IP` int NOT NULL,
	`userAgent` varchar(255) NOT NULL,
	`width_screen` int NOT NULL,
	`height_screen` int NOT NULL,
	`city` varchar(255) NOT NULL,
	`region` varchar(255) NOT NULL,
	`country` varchar(255) NOT NULL,
	`platform` varchar(255) NOT NULL,
	`time_in` int(12) NOT NULL,
	`time_out` int(12),
	`id_Site` int NOT NULL,
	`utm` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `ip` (
	`id` int NOT NULL AUTO_INCREMENT,
	`IP` varchar(16) NOT NULL,
	`isBad` bool NOT NULL DEFAULT false,
	`points` int NOT NULL DEFAULT 0,
	`history` varchar(555),
	PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
	`id` int NOT NULL AUTO_INCREMENT,
	`login` varchar(500) NOT NULL,
	`password` varchar(500) NOT NULL,
	`K_min` int NOT NULL,
	`N_sec` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `city` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(500) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `site_city` (
	`id_Site` int NOT NULL,
	`id_City` int NOT NULL
);

CREATE TABLE `site` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(500) NOT NULL,
	`id_User` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `click` ADD CONSTRAINT `click_fk0` FOREIGN KEY (`id_IP`) REFERENCES `ip`(`id`);
ALTER TABLE `click` ADD CONSTRAINT `click_fk1` FOREIGN KEY (`id_Site`) REFERENCES `site`(`id`);
ALTER TABLE `site_city` ADD CONSTRAINT `site_city_fk0` FOREIGN KEY (`id_Site`) REFERENCES `site`(`id`);
ALTER TABLE `site_city` ADD CONSTRAINT `site_city_fk1` FOREIGN KEY (`id_City`) REFERENCES `city`(`id`);
ALTER TABLE `site` ADD CONSTRAINT `site_fk0` FOREIGN KEY (`id_User`) REFERENCES `user`(`id`);

INSERT INTO `city`(`name`) VALUES ("Москва");
INSERT INTO `city`(`name`) VALUES ("Санкт-Петербург");
INSERT INTO `city`(`name`) VALUES ("Новосибирск");
INSERT INTO `city`(`name`) VALUES ("Екатеринбург");
INSERT INTO `city`(`name`) VALUES ("Омск");
INSERT INTO `city`(`name`) VALUES ("Хабаровск");
INSERT INTO `city`(`name`) VALUES ("Оренбург");
INSERT INTO `city`(`name`) VALUES ("Якутск");
INSERT INTO `city`(`name`) VALUES ("Жатай");