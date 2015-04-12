<?php

elgg_register_event_handler('init', 'system', 'gallery_field_init');

function gallery_field_init()
{
	// Register library
	elgg_register_library('elgg:gallery_field', __DIR__ . '/lib/gallery_field.php');	
	
    // Extend CSS
    elgg_extend_view('css/elgg', 'gallery_field/css');	
	
	// Javascript
	elgg_register_js('gallery_field_editor', '/mod/gallery_field/assets/gallery_field_editor.js');
	
	// Page handler for editor
	elgg_register_page_handler('gallery_field_image', 'gallery_field_image_page_handler');
	
	//Register actions
	$action_path = __DIR__."/actions";
	elgg_register_action("gallery_field/upload", "$action_path/upload.php");
	elgg_register_action("gallery_field/save_sort", "$action_path/save_sort.php");
}

function gallery_field_image_page_handler($page)
{
	elgg_load_library('elgg:gallery_field');
	if($page[0] == 'delete')
	{
		gallery_field_delete_images();
		return true;
	}	
	$image_id = elgg_extract(0, $page);
	$size = elgg_extract(1, $page, "default");
	gallery_field_show_image($image_id, $size);
	return true;
}


