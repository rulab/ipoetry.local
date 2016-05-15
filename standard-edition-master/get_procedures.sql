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
SELECT concat(user_email,user_password) into userpassword FROM ipoetry_user WHERE user_email = ipoetry_user_email and user_password=ipoetry_user_password LIMIT 1;
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
ipoetry_user_photo user_photo from 
ipoetry_user 
join ipoetry_user_phone on ipoetry_user.user_id=ipoetry_user_phone.ipoetry_user_phone_id 
join ipoetry_user_city on ipoetry_user.user_id=ipoetry_user_city.ipoetry_city_id
join ipoetry_user_age on ipoetry_user.user_id=ipoetry_user_age.ipoetry_user_age_id
join ipoetry_user_photo on ipoetry_user.user_id=ipoetry_user_photo.ipoetry_user_photo_id
join ipoetry_user_website on ipoetry_user.user_id=ipoetry_user_website.ipoetry_user_website_id
where user_email=ipoetry_user_email LIMIT 1;
END$$