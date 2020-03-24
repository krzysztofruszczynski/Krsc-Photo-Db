--------------------------------------------------------
--  DDL for Package Body PHOTO_PKG
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE PACKAGE BODY "YOURSCHEMA"."PHOTO_PKG" AS 
    FUNCTION get_fraction(in_mod_exposure FLOAT) RETURN VARCHAR2 IS
          v_fraction NUMBER;
    BEGIN
        v_fraction := 1 / in_mod_exposure;
        
        RETURN '1/'||round(v_fraction);
    END get_fraction;

    FUNCTION show_exposure_time(in_exposure FLOAT) RETURN VARCHAR2 IS
      v_mod_exposure FLOAT;
      v_result VARCHAR2(10);
    BEGIN
      v_mod_exposure := MOD(in_exposure,1);
      IF v_mod_exposure > 0 THEN
        IF in_exposure > 1 THEN
          v_result := floor(in_exposure)||' '||photo_pkg.get_fraction(v_mod_exposure);
        ELSE
          v_result := photo_pkg.get_fraction(v_mod_exposure);
        END IF;
      ELSE
        v_result := in_exposure;
      END IF;

      RETURN v_result||' s';
    END show_exposure_time;
    
    FUNCTION load_gps_data_by_date(in_date_start DATE DEFAULT NULL, in_date_finish DATE DEFAULT NULL) RETURN NUMBER IS    
    BEGIN
        SELECT photos_exif_gps_data_object(gpslatituderef, gpslatitude, gpslongituderef, gpslongitude, gpsaltituderef, gpsaltitude)
            BULK COLLECT INTO v_photos_exif_gps_data_array
                FROM photos_exif
                    WHERE (in_date_start IS NULL OR computed_date>=in_date_start)
                        AND (in_date_finish IS NULL OR computed_date<=in_date_finish)
        ;
        -- returns number of loaded gps data
        RETURN v_photos_exif_gps_data_array.COUNT;
    END load_gps_data_by_date;
    
    FUNCTION load_gps_data_by_filename(in_filename VARCHAR2, in_clear_previous_records NUMBER DEFAULT 1) RETURN NUMBER IS
        v_gps_data_object photos_exif_gps_data_object;
    BEGIN
        IF in_clear_previous_records = 1 THEN
            v_photos_exif_gps_data_array := photos_exif_gps_data_object_array();
        END IF;
        SELECT photos_exif_gps_data_object(gpslatituderef, gpslatitude, gpslongituderef, gpslongitude, gpsaltituderef, gpsaltitude)
            INTO v_gps_data_object
                FROM photos_exif
                    WHERE filename=in_filename
        ;
        v_photos_exif_gps_data_array.extend();
        v_photos_exif_gps_data_array(v_photos_exif_gps_data_array.COUNT) := v_gps_data_object;
        
        RETURN 1;
    END load_gps_data_by_filename;
END photo_pkg;

/