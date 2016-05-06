insert into ipoetry_user (user_id,ipoetry_user_parent_id,user_name,user_password,user_email) values(0,0,'test_user','test_password','test@mail.ru');

insert into ipoetry_classic_authors_has_ipoetry_user (ipoetry_user_user_id,ipoetry_user_ipoetry_user_parent_id,ipoetry_classic_authors_ipoetry_classic_authors_id) values (0,0,1);

/*запролнение таблиц личного кабинета значениями для тестового пользователя*/
#заполняем таблицу фото
INSERT INTO `ipoetry`.`ipoetry_user_photo` (`ipoetry_user_photo_id`, `user_photo_url`) VALUES ('0', '/public/iamges/default.jpg');
#заполняем таблицу город
INSERT INTO `ipoetry`.`ipoetry_user_city` (`ipoetry_city_id`, `city_name`) VALUES ('0', 'undefined');
#заполняем таблицу возраст
INSERT INTO `ipoetry`.`ipoetry_user_age` (`ipoetry_user_age_id`, `ipoetry_user_age`) VALUES ('0', '35');
#заполняем таблицу возраст
INSERT INTO `ipoetry`.`ipoetry_user_age` (`ipoetry_user_age_id`, `ipoetry_user_age`) VALUES ('0', '35');
#заполняем таблицу статус
INSERT INTO `ipoetry`.`ipoetry_user_status` (`ipoetry_user_status`) VALUES ('initial');
INSERT INTO `ipoetry`.`ipoetry_user_status` (`ipoetry_user_status`) VALUES ('approved');
#заполняем таблицу website
INSERT INTO `ipoetry`.`ipoetry_user_website` (`ipoetry_user_website_id`, `ipoetry_user_website`) VALUES ('0', 'undefined');
#заполняем таблицу phone
INSERT INTO `ipoetry`.`ipoetry_user_phone` (`ipoetry_user_phone_id`, `ipoetry_user_phone`) VALUES ('0', 'undefined');
#заполняем таблицу подписчики пользователя
INSERT INTO `ipoetry`.`ipoetry_user_followers` (`ipoetry_user_followers_id`, `ipoetry_user_user_id`, `ipoetry_user_user_parent_id`) VALUES ('0', '0', '0');
#заполняем таблицу на кого подписан пользователь
INSERT INTO `ipoetry`.`ipoetry_user_followed_by` (`ipoetry_user_followed_by_id`, `ipoetry_user_user_id`, `ipoetry_user_user_parent_id`) VALUES ('0', '0', '0');
#заполняем тестового пользователя
INSERT INTO `ipoetry`.`ipoetry_user` (
`user_id`, 
`user_name`, 
`user_password`, 
`user_lastname`, 
`user_email`, 
`user_phone_id`, 
`user_photo_id`, 
`user_city_id`, 
`user_age_id`, 
`user_status_id`, 
`user_rating_id`, 
`user_post_message_id`, 
`user_poetry_id`, 
`user_event_id`, 
`user_group_id`, 
`user_parent_id`, 
`user_website_id`, 
`ipoetry_user_followers_can_read`) VALUES (
0,
'test_user',
'test_password',
'test@mail.ru',
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0);

#заполняем направления в поэзии
insert into `ipoetry`.`ipoetry_poetry_types` (`ipoetry_poetry_types`) values ('Классицизм');
insert into `ipoetry`.`ipoetry_poetry_types` (`ipoetry_poetry_types`) values ('Романтизм');
insert into `ipoetry`.`ipoetry_poetry_types` (`ipoetry_poetry_types`) values ('Поэт-классик');
#заполняем класиков
insert into ipoetry_classic_authors (classic_authors_name) values ('Ю.Лермонтов');
insert into ipoetry_classic_authors (classic_authors_name) values ('И.Бродский');
insert into ipoetry_classic_authors (classic_authors_name) values ('Б.Захадер');
insert into ipoetry_classic_authors (classic_authors_name) values ('А.Пушкин');
insert into ipoetry_classic_authors (classic_authors_name) values ('Б.Пастернак');
insert into ipoetry_classic_authors (classic_authors_name) values ('З.Гипиус');