# PHP-My-Blog

This is my PHP project from the Udemy course. It is the CMS application for post publishing.

### Dependencies:

* PHP 8.1.2
* MySQL 8.0.33
* Apache2 2.4.52
* PhpMyAdmin 8.0.33
* Bootstrap5 5.3.0
* JQuery 3.7.0
* JQuery Validation Plugin 1.19.5
* JQuery DateTimePicker 
* PhpDocumentor 3.3.1 (optional)

### Installation:

Notes: I use Ubuntu, so installation algorithm is described for this system.

Also I write the algorithm for installation of the last programs' versions. I use this site for it: `https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-22-04`

AND

`https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-phpmyadmin-on-ubuntu-22-04`.

1. Install Apache2, PHP, MySQL and PhpMyAdmin. There are a lot of guides how to install LAMP and config it. For PHP you can use:
```commandline
sudo apt update
sudo apt install php libapache2-mod-php php-mysql
sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl
```
2. Config apache virtual host. The document root for your site in the virtual host has to be:
```commandline
<VirtualHost '...':80>
    ServerName 'your_domain'
    ServerAlias www.'your_domain' 
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/public/'your_domain'
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
3. Clone the project:
```commandline
git clone https://github.com/BabaykaBo/PHP-My-Blog.git
```
4. In PhpMyAdmin you can use this SQL for creating tables:
```commandline
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post` (
  `id` int NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `image_file` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `post_category` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`);

ALTER TABLE `post_category`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `post_category`
  ADD CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

```
5.  Rename __config.php into config.php and replace '...' on actual data.
6.  Give access to uploading folder:
```commandline
sudo chown -R :'www-data' public/uploading/
```
7. in PhpMyAdmin in user table create user (name and password). Password should be hashed, for example, use this site: `https://randommer.io/Hash/SHA256`
8. Restart apache server and go to your site in browser:
```commandline
http://'your_domain_or_IP'
```
## Features:

### User authentication system
* login and logout existing user.
* unauthorized users can only watch the content, another  functionality will be unavailable.

### Guest
* view a list of post.
* view an information about the specific post.

### Admin
* All features accessible for guest.
* Create new posts.
* Edit posts.
* Edite an image for posts.
* Delete posts.
* Delete an image for posts.
* Have access to admin page.
* Publish posts.
