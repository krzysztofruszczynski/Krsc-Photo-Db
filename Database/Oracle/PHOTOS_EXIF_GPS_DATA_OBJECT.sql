--------------------------------------------------------
--  DDL for Type PHOTOS_EXIF_GPS_DATA_OBJECT
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TYPE "YOURSCHEMA"."PHOTOS_EXIF_GPS_DATA_OBJECT" AS OBJECT 
(
    gps_latitude_ref CHAR(1),
    gps_latitude NUMBER(8,6),
    gps_longitude_ref CHAR(1),
    gps_longitude NUMBER(8,6),
    gps_altitude_ref NUMBER(1),
    gps_altitude NUMBER(7,2),

    MEMBER FUNCTION get_altitude RETURN VARCHAR2
);
/
CREATE OR REPLACE NONEDITIONABLE TYPE BODY "YOURSCHEMA"."PHOTOS_EXIF_GPS_DATA_OBJECT" AS
    MEMBER FUNCTION get_altitude RETURN VARCHAR2 IS
        v_factor NUMBER(1);
    BEGIN
        SELECT
            (CASE gps_altitude_ref
            WHEN 0 THEN 1
            WHEN 1 THEN -1
            END) 
                INTO v_factor
                    FROM dual;  
        RETURN FLOOR(gps_altitude)*v_factor||' meters above sea level';
    END get_altitude;
END;

/
