<?php

elgg_load_library('elgg:gallery_field');
elgg_load_js('gallery_field_editor');

$entity = elgg_extract('entity', $vars, '');
$field = elgg_extract('field', $vars, '');

$image_ids = gallery_field_image_ids_from_value($entity->$field);
$canEdit = $entity->canEdit();

$class = 'gallery-field-images-list collapsed';

if($canEdit)
{
	$class .= " gallery-field-editor";
}
?>

<div class="<?=$class?>" data-entity-id='<?=$entity->guid?>' data-entity-field="<?=$field?>">
	
<?php if($canEdit) { 
		
		echo "<a class='editor_toggler' href='#'>".elgg_echo("gallery_field:edit_images")."</a>";
		
		echo "<div class='editor' style='display:none;'>";
		{			
			
			echo "<div class='editor_main'>";
			{
				echo elgg_view_form('gallery_field/upload', array(
					'enctype' => 'multipart/form-data',
					'style' => 'height: 0; overflow: hidden;'
				), array(
					'entity' => $entity,
					'field' => $field
				));

				echo elgg_view('input/button', array(
					'value' => elgg_echo('gallery_field:upload_images'),
					'class' => 'elgg-button-action upload-btn'
				));		

				echo elgg_view('input/button', array(
					'value' => elgg_echo('gallery_field:delete_images'),
					'class' => 'elgg-button-delete delete-btn'
				));				

				echo elgg_view('input/button', array(
					'value' => elgg_echo('cancel'),
					'class' => 'elgg-button-cancel edit-cancel-btn'
				));		
			}
			echo "</div>";

			echo "<span class='delete_images' style='display:none;'>";
			{

				echo elgg_view('input/button', array(
					'value' => elgg_echo('gallery_field:delete_images'),
					'class' => 'elgg-button-delete delete-confirm-btn',
					'data-confirm-text' => elgg_echo('gallery_field:delete_confirm'),
					'data-empty-text' => elgg_echo('gallery_field:delete_empty')
				));				

				echo elgg_view('input/button', array(
					'value' => elgg_echo('cancel'),
					'class' => 'elgg-button-cancel delete-cancel-btn'
				));							

			}
			echo "</spen>";
		}
		echo "</div>";
	} ?>	
	
	
	<div class="images">
		<div class='dragger'>
		<?php 
			foreach($image_ids as $image_id){ 				
		?>
			<div class="image">
				<a href="/gallery_field_image/<?=$image_id?>" data-image-id="<?=$image_id?>">
					<img src="/gallery_field_image/<?=$image_id?>/thumb"/>
				</a>
			</div>
		<?php 			
			} 
		?>
		</div>
		<div class='clear'></div>
	</div>	
	<div class="image_full"></div>
			
</div>

