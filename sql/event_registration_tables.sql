-- Event configuration table
CREATE TABLE `event_registration_event` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_name` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `event_date` DATE NOT NULL,
  `reg_start` DATE NOT NULL,
  `reg_end` DATE NOT NULL,
  `created` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Event registrations table
CREATE TABLE `event_registration_signup` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` INT UNSIGNED NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `college` VARCHAR(255) NOT NULL,
  `department` VARCHAR(255) NOT NULL,
  `created` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
