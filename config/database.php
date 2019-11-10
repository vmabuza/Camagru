<?php
function createDatabase() {

    try {
        $db = new PDO('mysql:host=' . HOST . ';', SQL_UNAME, PASS);
        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        $db->exec($sql);
        
        $sql = "use " . DB_NAME;
        $db->exec($sql);
        
        $sql = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
            `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
            `fname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
            `lname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
            `acl` text COLLATE utf8mb4_unicode_ci,
            `confirmed` tinyint(1) DEFAULT '0',
            `deleted` tinyint(4) DEFAULT '0',
            `notifications` tinyint(1) DEFAULT '1',
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);

        $sql = "CREATE TABLE `user_sessions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `session` varchar(255) NOT NULL,
        `user_agent` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);

        $sql = "CREATE TABLE `image` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `image_data` longblob NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);

        $sql = "CREATE TABLE `comments` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `image_id` int(11) NOT NULL,
        `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
        CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);

        $sql = "CREATE TABLE `likes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `comment_id` int(11) DEFAULT NULL,
    `image_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `image_id` (`image_id`),
    KEY `comment_id` (`comment_id`),
    CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
    CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);

        $sql = "CREATE TABLE `confirm` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `confirmation_str` varchar(150) CHARACTER SET utf8 NOT NULL,
        `confirmed` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `confirm_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $db->exec($sql);
    } catch(PDOException $e) {
        die($e->getMessage());
    }
}
?>