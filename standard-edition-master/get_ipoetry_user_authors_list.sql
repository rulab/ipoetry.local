DELIMITER $$

create procedure get_ipoetry_user_authors_list(IN ipoetry_user_id INT(11),OUT authors_list VARCHAR(255))
DETERMINISTIC
READS SQL DATA
BEGIN
SELECT ipoetry_classic_authors_name authors_list from ipoetry_classic_authors ica right join ipoetry_user_ipoetry_classic_authors_relation iui_car on ica.ipoetry_classic_authors_id=iui_car.ipoetry_classic_authors_ipoetry_classic_authors_id where iui_car.ipoetry_user_user_id=ipoetry_user_id;
END$$

