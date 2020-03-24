--------------------------------------------------------
--  DDL for Trigger PHOTOS_EXIF_BIS_TRG
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "YOURSCHEMA"."PHOTOS_EXIF_BIS_TRG" 
BEFORE INSERT ON photos_exif
FOR EACH ROW
BEGIN
  :NEW.ID := photos_exif_seq.NEXTVAL;
END;
/
ALTER TRIGGER "YOURSCHEMA"."PHOTOS_EXIF_BIS_TRG" ENABLE;
