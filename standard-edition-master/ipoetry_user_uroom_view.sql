CREATE VIEW `ipoetry_user_uroom` AS
    SELECT 
        `iusr`.`user_name` AS `user_name`,
        `iusr`.`user_lastname` AS `user_lastname`,
        `iusr_city`.`city_name` AS `user_city`,
        `iusr_age`.`ipoetry_user_age` AS `user_age`,
        `iusr_website`.`ipoetry_user_website` AS `user_website`
    FROM
        ((((`ipoetry`.`ipoetry_user` `iusr`
        JOIN `ipoetry`.`ipoetry_user_photo` `iusr_photo` ON ((`iusr`.`user_photo_id` = `iusr_photo`.`ipoetry_user_photo_id`)))
        JOIN `ipoetry`.`ipoetry_user_city` `iusr_city` ON ((`iusr`.`user_city_id` = `iusr_city`.`ipoetry_city_id`)))
        JOIN `ipoetry`.`ipoetry_user_age` `iusr_age` ON ((`iusr`.`user_age_id` = `iusr_age`.`ipoetry_user_age_id`)))
        JOIN `ipoetry`.`ipoetry_user_website` `iusr_website` ON ((`iusr`.`user_website_id` = `iusr_website`.`ipoetry_user_website_id`)))