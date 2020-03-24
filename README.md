Krsc-Photo-Db
===========
Tool to store in db and analyse exif data from photos.

Import metadata
===========
In order to import metadata from photos, please use:
<pre>
php ImportCommand.php /my/directory/with/photos sql_file.sql
</pre>
Where <pre>/my/directory/with/photos</pre> is folder, which is recursively searched for photos and <pre>sql_file.sql</pre> is dynamically generated file with import. If second parameter is omitted, sql data will be displayed in output.
