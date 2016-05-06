CREATE VIEW `ipoetry_user_uroom` AS
select user_name,
user_lastname,
city_name user_city,
ipoetry_user_age user_age,
ipoetry_user_website user_website
from
ipoetry_user iusr join ipoetry_user_photo iusr_photo on iusr.user_photo_id=iusr_photo.ipoetry_user_photo_id
join ipoetry_user_city iusr_city on iusr.user_city_id=iusr_city.ipoetry_city_id
join ipoetry_user_age iusr_age on iusr.user_age_id=iusr_age.ipoetry_user_age_id
join ipoetry_user_website iusr_website on iusr.user_age_id=iusr_website.ipoetry_user_website;