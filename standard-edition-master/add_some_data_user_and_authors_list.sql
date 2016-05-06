insert into ipoetry_user (user_id,ipoetry_user_parent_id,user_name,user_password,user_email) values(0,0,'test_user','test_password','test@mail.ru');

insert into ipoetry_classic_authors_has_ipoetry_user (ipoetry_user_user_id,ipoetry_user_ipoetry_user_parent_id,ipoetry_classic_authors_ipoetry_classic_authors_id) values (0,0,1);

insert into ipoetry_classic_authors (ipoetry_classic_authors_name) values ('З.Гипиус');

