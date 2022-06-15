<?php

function insert_data_table(){
	if( isset($_POST['my_file_upload']) ) {
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	global $wpdb;
	$uploadedfile = $_FILES['image'];
	$upload_overrides = array( 'test_form' => false );
	$image = wp_handle_upload( $uploadedfile, $upload_overrides );
	$image_name = $image['url'];
	$image_path = strstr($image_name, 2022);
	if ( $image ) {           
		echo '<img src="'.$image_name.'">';
		echo "File is successfully uploaded.\n";
		echo "$image_path";
	} else {
		echo "Possible file upload error!\n";
	}
	$table_name = $wpdb->prefix . "upload_images";
	$wpdb->insert(
			$table_name,
			array(
			'images'      => $image_path
			), '%s'
		);
	}
}
?>
<form id="file_upload" method="post" action="#" enctype="multipart/form-data">
<label for"image">Image</label>
<input name="image" type="file" id="image" value="" />
    <input name="my_file_upload" type="submit" value="Upload" />
</form>


<?php
global $wpdb;
$table_name = $wpdb->prefix . "upload_images";
$result = $wpdb->get_results ( "
SELECT images FROM $table_name;
" );
$array = json_decode(json_encode($result), true);

foreach ( $array as $key => $value )
{
	$url = home_url('wp-content/uploads/'.$value['images']);
	$create_image = '<img src="'.$url.'">';
	echo $create_image;
}
?>