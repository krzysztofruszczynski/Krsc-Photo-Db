--------------------------------------------------------
--  DDL for Index PHOTOS_EXIF_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "YOURSCHEMA"."PHOTOS_EXIF_PK" ON "YOURSCHEMA"."PHOTOS_EXIF" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;