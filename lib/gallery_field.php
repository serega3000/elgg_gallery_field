<?php

/** 
 * @param string $value Value of model where stored image ids
 * @return array Array of file ids
 */
function gallery_field_image_ids_from_value($value)
{
	if(strlen($value) == 0 || intval($value) == 0)
	{
		return array();
	}
	$return_value = array();
	$value_arr = explode(",", $value);
	foreach($value_arr as $value_item)
	{
		$value_item_int = intval($value_item);
		if($value_item_int > 0)
		{
			$return_value[] = $value_item_int;
		}
	}
	return $return_value;
}

function gallery_field_delete_images()
{
	$entity_id = $_POST['entity_id'];
	$field = $_POST['field'];
	$delete_images_list = $_POST['images'];
	$delete_ids = explode(",", $delete_images_list);
		
	
	$entity = get_entity($entity_id);
	if(false == $entity->canEdit())
	{
		throw new Exception("can`t edit");
	}
	
	$current_image_ids = gallery_field_image_ids_from_value($entity->$field);
	$new_image_ids = array();
	foreach($current_image_ids as $image_id)
	{
		if(in_array($image_id, $delete_ids))
		{
			$image_entity = get_entity($image_id);
			if($image_entity)
			{
				$image_entity->delete();
			}
		}
		else
		{
			$new_image_ids[] = $image_id;
		}
	}
	
	$entity->$field = implode(",", $new_image_ids);
	$entity->save();
	
	echo "ok";	
}

function gallery_field_show_image($image_id, $size = "default")
{
	/* @var $image GalleryFieldImage */
	$image = get_entity($image_id);
	if($size == 'thumb')
	{
		$image = get_entity($image->thumb_file_guid);
	}
	elseif(in_array($size, array('small','tiny')))
	{
		$image = $image->getIconFile($size);
	}
	
	
	$success = false;
	$contents = null;
	
	if ($image->open("read")) {
		
		$contents = $image->read($image->getSize());		
		if ($contents) {
			$success = true;
		}
		$image->close();
	}	
	
	if($success == false)
	{
		throw new Exception("can`t read image");
	}
	
	header("Content-type: ".$image->getMimeType(), true);
	header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
	header("Pragma: public", true);
	header("Cache-Control: public", true);
	header("Content-Length: " . strlen($contents));

	echo $contents;	
	
	
}

function gallery_field_save_sort()
{
	$entity_id = $_POST['entity_id'];
	$field = $_POST['field'];
	$sort_images_list = $_POST['images'];
	$sort_ids = explode(",", $sort_images_list);	
	
	$entity = get_entity($entity_id);
	if(false == $entity->canEdit())
	{
		throw new Exception("can`t edit");
	}	
	
	$current_image_ids = gallery_field_image_ids_from_value($entity->$field);
	
	if(count($current_image_ids) == 0)
	{
		return;
	}	
	/**
	 * check if all values persist in both arrays
	 */
	if(count(array_intersect($sort_ids, $current_image_ids)) != count($current_image_ids))
	{
		throw new Exception("bad count");
	}
	
	$entity->$field = implode(",", $sort_ids);
	$entity->save();
}

function gallery_field_get_entity_icon_file_id(ElggEntity $entity, $field = 'images')
{
	$image_ids = gallery_field_image_ids_from_value($entity->$field);	

	if(count($image_ids) == 0)
	{
		return null;
	}
	
	return $image_ids[0];
}

function gallery_field_get_entity_icon_url(ElggEntity $entity, $size = 'small', $field = 'images')
{
	$id = gallery_field_get_entity_icon_file_id($entity, $field);

	if($id == null)
	{
		return null;
	}

	return "/gallery_field_image/{$id}/{$size}";			
}

/**
 * 
 * @param ElggEntity $entity
 * @return ElggFile
 */
function gallery_field_get_entity_icon_file(ElggEntity $entity)
{	
	$id = gallery_field_get_entity_icon_file_id($entity, $field);
	if($id == null)
	{
		return null;
	}

	return get_entity($id);		
}