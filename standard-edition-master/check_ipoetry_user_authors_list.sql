CALL `ipoetry`.`get_ipoetry_user_authors_list`(0, @a_list);
CALL `ipoetry`.`get_ipoetry_user`('test@mail.ru','test_password');

SELECT ipoetry_classic_authors_id,ipoetry_classic_authors_name authors_list from ipoetry_classic_authors ica join ipoetry_classic_authors_has_ipoetry_user ica_hiu on ica.ipoetry_classic_authors_id=ica_hiu.ipoetry_classic_authors_ipoetry_classic_authors_id where ica_hiu.ipoetry_user_user_id=0;
SELECT * from ipoetry_classic_authors_has_ipoetry_user;