--------------------------------------------------------
--  DDL for View V_PHOTOS_EXIF_IMPROPER_COMMENT_STATISTICS
--------------------------------------------------------

  CREATE OR REPLACE FORCE NONEDITIONABLE VIEW "YOURSCHEMA"."V_PHOTOS_EXIF_IMPROPER_COMMENT_STATISTICS" ("CHAR_USER_COMMENT", "NUMBER_OF_OCCURENCE") AS 
  SELECT A.char_user_comment, COUNT(1) AS number_of_occurence 
        FROM (SELECT to_char(usercomment) AS char_user_comment FROM photos_exif WHERE usercomment LIKE 'ASCII%') A
        GROUP BY A.char_user_comment
;
