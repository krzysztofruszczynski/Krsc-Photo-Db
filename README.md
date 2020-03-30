Krsc-Photo-Db
===========
Tool to import, store in db and analyse exif data from photos.

Import metadata
===========
In order to import metadata from photos, please use:
<pre>
php ImportCommand.php /my/directory/with/photos sql_file.sql
</pre>
Where <pre>/my/directory/with/photos</pre> is folder, which is recursively searched for photos and <pre>sql_file.sql</pre> is dynamically generated file with import. If second parameter is omitted, sql data will be displayed in output.

Oracle db
===========
In Database/Oracle folder are sql files with database for storing photos. Please change schema name "YOURSCHEMA" to your own needs.
After importing sql made via ImportCommand.php you are able to create gpx file with photo locations. To decide, which photos are taken into account, you can use two methods:
<pre>
BEGIN
    photo_pkg.load_gps_data_by_filename('IMG_10282_g.JPG');
END;
</pre>
Imports only selected photo. Optional second parameter decides, if previous data stays. If stays it should be 0, like in this example:
<pre>
BEGIN
    photo_pkg.load_gps_data_by_filename('IMG_10282_g.JPG');
    photo_pkg.load_gps_data_by_filename('IMG_10283_g.JPG', 0);
END;
</pre>
In such case both photos are loaded. To check number of loaded photos you can use pipelined function:
<pre>
select * from photo_pkg.gps_table();
</pre>
You can also load all photos matching specified date range (first start date, second finish date; both or one of parameters can be null):
<pre>
BEGIN
    photo_pkg.load_gps_data_by_date('15/01/01', '20/08/01');
END;</pre>
After data are loaded, you can create gpx file with method: <pre>photo_pkg.get_gpx_file_content</pre> with obligatory CLOB parameter. It is possible to write it directly to console (with bigger set of data the only way to avoid errors, please adjust buffer size) or by out variable. Second optional parameter decides about this (by default console, if input: 0 then data is inside out variable, given as first parameter).
Example using out variable:
<pre>
DECLARE
    out_content CLOB;
BEGIN
    photo_pkg.load_gps_data_by_filename('IMG_10282_g.JPG');
    photo_pkg.load_gps_data_by_filename('IMG_10283_g.JPG', 0);
    photo_pkg.get_gpx_file_content(out_content, 0);
    dbms_output.put_line(out_content);
END;
</pre>
Below example using console (probably bigger set of data):
<pre>
DECLARE
    out_content CLOB;
BEGIN
    photo_pkg.load_gps_data_by_date('15/01/01');
    photo_pkg.get_gpx_file_content(out_content);
END;
</pre>
In example above, only start date is provided. If first parameter is set to NULL, only finish date can be provided.

Other functions for working with gps data:
<pre>
BEGIN
    photo_pkg.load_gps_data_by_filename('IMG_10282_g.JPG');
    dbms_output.put_line(photo_pkg.v_photos_exif_gps_data_array(1).get_altitude);
    dbms_output.put_line(photo_pkg.v_photos_exif_gps_data_array(1).get_google_maps_url);
    dbms_output.put_line(photo_pkg.v_photos_exif_gps_data_array(1).get_trackpoint);
END;
</pre>
Function get_altitude returns attitude for photo (like "2096 meters above sea level"), get_google_maps_url returns url showing point on google map and get_trackpoint returns gpx element with photo coordinates.
