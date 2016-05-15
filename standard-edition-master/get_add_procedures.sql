DELIMITER $$

create procedure get_ipoetry_user_authors_list(IN ipoetry_user_id INT(11),OUT authors_list VARCHAR(255))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT ipoetry_classic_authors_name into authors_list from ipoetry_classic_authors ica right join ipoetry_user_ipoetry_classic_authors_relation iui_car on ica.ipoetry_classic_authors_id=iui_car.ipoetry_classic_authors_ipoetry_classic_authors_id where iui_car.ipoetry_user_user_id=ipoetry_user_id;
END$$

create procedure get_ipoetry_user_poetry_types_list(IN ipoetry_user_id INT(11),OUT poetry_types_list VARCHAR(255))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT ipoetry_poetry_types into poetry_types_list from ipoetry_poetry_types ipt right join ipoetry_user_ipoetry_poetry_types_relation iui_ptr on ipt.ipoetry_poetry_types_id=iui_ptr.ipoetry_poetry_types_ipoetry_poetry_types_id where iui_ptr.ipoetry_user_user_id=ipoetry_user_id;
END$$

create procedure get_ipoetry_user(IN ipoetry_user_email varchar(255),IN ipoetry_user_password VARCHAR(20),OUT userpassword VARCHAR(255))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT concat(user_email,user_password) userpassword FROM ipoetry_user WHERE user_email = ipoetry_user_email and user_password=ipoetry_user_password LIMIT 1;
END$$

create procedure get_ipoetry_user_room_info(IN ipoetry_user_email varchar(255))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT user_name,
user_lastname,
user_password,
user_email,
ipoetry_user_phone user_phone,
city_name user_city,
ipoetry_user_age user_age,
ipoetry_user_website user_website,
user_photo from 
ipoetry_user 
join ipoetry_user_phone on ipoetry_user.user_id=ipoetry_user_phone.ipoetry_user_phone_id 
join ipoetry_user_city on ipoetry_user.user_id=ipoetry_user_city.ipoetry_city_id
join ipoetry_user_age on ipoetry_user.user_id=ipoetry_user_age.ipoetry_user_age_id
join ipoetry_user_photo on ipoetry_user.user_id=ipoetry_user_photo.ipoetry_user_photo_id
join ipoetry_user_website on ipoetry_user.user_id=ipoetry_user_website.ipoetry_user_website_id
where user_email=ipoetry_user_email LIMIT 1;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `add_ipoetry_user`(IN `ipoetry_user_name` varchar(50),IN `ipoetry_user_lastname` varchar(50),IN `ipoetry_user_email` varchar(255),IN `ipoetry_user_password` VARCHAR(20),IN `ipoetry_user_md5hash` VARCHAR(32),IN `db_name` varchar(255),IN `tbl_name` varchar(255))
    MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
START TRANSACTION;

INSERT INTO `ipoetry_user_photo`
(`ipoetry_user_photo_id`)
values ((SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`));
INSERT INTO `ipoetry_user_phone`
(`ipoetry_user_phone_id`)
values ((SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`));
INSERT INTO `ipoetry_user_city`
(`ipoetry_city_id`)
values ((SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`));
INSERT INTO `ipoetry_user_age`
(`ipoetry_user_age_id`)
values ((SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`));
INSERT INTO `ipoetry_user_website`
(`ipoetry_user_website_id`)
values ((SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`));

INSERT INTO `ipoetry`.`ipoetry_user`
(`user_name`,
`user_password`,
`user_lastname`,
`user_email`,
`user_phone_id`,
`user_photo_id`,
`user_city_id`,
`user_age_id`,
`user_rating_id`,
`user_post_message_id`,
`user_poetry_id`,
`user_event_id`,
`user_group_id`,
`user_parent_id`,
`user_website_id`,
`ipoetry_user_followers_can_read`,
`ipoetry_user_md5`)
VALUES
(ipoetry_user_name,
ipoetry_user_password,
ipoetry_user_lastname,
ipoetry_user_email,
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
(SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = `db_name` AND TABLE_NAME = `tbl_name`),
0,
ipoetry_user_md5hash);
COMMIT;
END$$

create procedure get_ipoetry_user_md5(IN user_md5 char(32))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT case when (SELECT 1 ipoetry_user_md5 FROM ipoetry.ipoetry_user WHERE ipoetry_user_md5 = user_md5 and ipoetry_user_email_is_verified=0 LIMIT 1)=1 then 1 else 0 end ipoetry_user_md5;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `set_user_md5_status`(IN `user_md5` char(32),IN `user_email_is_verified` boolean)
    MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
UPDATE ipoetry.ipoetry_user set ipoetry_user_email_is_verified=user_email_is_verified where ipoetry_user_md5=user_md5;
COMMIT;
END$$
