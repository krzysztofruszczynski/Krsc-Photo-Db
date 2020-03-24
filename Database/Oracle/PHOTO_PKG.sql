--------------------------------------------------------
--  DDL for Package PHOTO_PKG
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE PACKAGE "YOURSCHEMA"."PHOTO_PKG" AS
    TYPE photos_exif_gps_data_object_array IS TABLE OF photos_exif_gps_data_object;
    v_photos_exif_gps_data_array photos_exif_gps_data_object_array := photos_exif_gps_data_object_array();

    FUNCTION get_fraction(in_mod_exposure FLOAT) RETURN VARCHAR2;
    FUNCTION show_exposure_time(in_exposure FLOAT) RETURN VARCHAR2;
    FUNCTION load_gps_data_by_date(in_date_start DATE DEFAULT NULL, in_date_finish DATE DEFAULT NULL) RETURN NUMBER;
    FUNCTION load_gps_data_by_filename(in_filename VARCHAR2, in_clear_previous_records NUMBER DEFAULT 1) RETURN NUMBER;
END photo_pkg;

/
