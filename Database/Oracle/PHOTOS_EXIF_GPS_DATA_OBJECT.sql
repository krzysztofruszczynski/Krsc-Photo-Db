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

    MEMBER FUNCTION from_number_to_string_with_point(in_number NUMBER) RETURN VARCHAR2,
    MEMBER FUNCTION get_altitude (in_description VARCHAR2 DEFAULT ' meters above sea level') RETURN VARCHAR2,
    MEMBER FUNCTION get_google_maps_url RETURN VARCHAR2,
    MEMBER FUNCTION get_decimal_latitude RETURN NUMBER,
    MEMBER FUNCTION get_decimal_longitude RETURN NUMBER,
    MEMBER FUNCTION get_trackpoint RETURN VARCHAR2
);
/
CREATE OR REPLACE NONEDITIONABLE TYPE BODY "YOURSCHEMA"."PHOTOS_EXIF_GPS_DATA_OBJECT" AS
    MEMBER FUNCTION from_number_to_string_with_point(in_number NUMBER) RETURN VARCHAR2 IS
    BEGIN
        RETURN REPLACE(CAST(in_number AS VARCHAR2), ',', '.');
    END from_number_to_string_with_point;

    MEMBER FUNCTION get_altitude(in_description VARCHAR2 DEFAULT ' meters above sea level') RETURN VARCHAR2 IS
        v_factor NUMBER(1);
    BEGIN
        SELECT
            (CASE gps_altitude_ref
            WHEN 0 THEN 1
            WHEN 1 THEN -1
            END) 
                INTO v_factor
                    FROM dual;  

        RETURN FLOOR(gps_altitude)*v_factor||in_description;
    END get_altitude;
    
    MEMBER FUNCTION get_google_maps_url RETURN VARCHAR2 AS
        v_gps_latitude VARCHAR2(9) := from_number_to_string_with_point(gps_latitude);
        v_gps_longitude VARCHAR2(9) := from_number_to_string_with_point(gps_longitude);
    BEGIN
        RETURN 'https://www.google.pl/maps/search/'||v_gps_latitude||'+'||gps_latitude_ref||'+'||v_gps_longitude||'+'||gps_longitude_ref||'/';
    END get_google_maps_url;
    
    MEMBER FUNCTION get_decimal_latitude RETURN NUMBER AS
        v_factor NUMBER(1) := 1;
    BEGIN
        IF gps_latitude_ref = 'S' THEN
            v_factor := -1;
        END IF;

        RETURN v_factor * gps_latitude;            
    END get_decimal_latitude;

    MEMBER FUNCTION get_decimal_longitude RETURN NUMBER AS
        v_factor NUMBER(1) := 1;
    BEGIN
        IF gps_longitude_ref = 'W' THEN
            v_factor := -1;
        END IF;
        
        RETURN v_factor * gps_longitude;
    END get_decimal_longitude;

    MEMBER FUNCTION get_trackpoint RETURN VARCHAR2 AS
    BEGIN
        RETURN utl_lms.format_message('<trkpt lat="%s" lon="%s"><ele>%s</ele></trkpt>', from_number_to_string_with_point(get_decimal_latitude), from_number_to_string_with_point(get_decimal_longitude), TO_CHAR(get_altitude('')));
    END get_trackpoint;
END;

/
