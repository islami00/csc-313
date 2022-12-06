CREATE TABLE `users`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `firstname` VARCHAR(255) NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','normal') NOT NULL DEFAULT 'normal' COMMENT 'admin,normal',
    `level` ENUM('beginner','intermediate','expert') NOT NULL DEFAULT 'beginner' COMMENT 'beginner,intermediate,expert.
Admin are experts',
    `profile_picture` VARCHAR(255) NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone_number` INT NULL,
    `gender` VARCHAR(255) NULL
);
ALTER TABLE
    `users` ADD PRIMARY KEY `users_id_primary`(`id`);
ALTER TABLE
    `users` ADD UNIQUE `users_email_unique`(`email`);
CREATE TABLE `topics`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `uploaded_file_name` VARCHAR(255) NOT NULL COMMENT 'We dont use urls, we instead use the filename to allow upload directory to change.

An alternative would have the files be urls and run a sql if we want to update the path',
    `level` ENUM('beginner','intermediate','expert') NOT NULL,
    `admin_id` INT NOT NULL COMMENT 'Related admin will be gotten from this. An admin can upload many topics. an admin is ideally an instructor',
    `createdAt` TIMESTAMP NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
    `updatedAt` TIMESTAMP NOT NULL DEFAULT 'CURRENT_TIMESTAMP'
);
ALTER TABLE
    `topics` ADD PRIMARY KEY `topics_id_primary`(`id`);
ALTER TABLE
    `topics` ADD CONSTRAINT `topics_admin_id_foreign` FOREIGN KEY(`admin_id`) REFERENCES `users`(`id`);