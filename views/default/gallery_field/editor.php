<?php

elgg_load_library('elgg:gallery_field');

$value = empty($vars['value']) ? "" : $vars['value'];
$entity = elgg_extract('entity', $vars, '');

if (!empty($vars['value'])) {
	echo elgg_echo('fileexists') . "<br />";
}

if (isset($vars['class'])) {
	$vars['class'] = "elgg-gallery-editor {$vars['class']}";
} else {
	$vars['class'] = "elgg-gallery-editor";
}

$defaults = array(
	'disabled' => false,
);

$image_ids = gallery_field_image_ids_from_value($value);

$attrs = array_merge($defaults, $vars);
$attrs['value'] = implode(",", $image_ids);

?>
<div class="<?=$vars['class']?>" id='gallery-field-editor' data-entity-id='<?=$entity->guid?>'>	
	<?=elgg_view('input/button', array(
		'value' => elgg_echo('gallery_field:upload_images'),
		'class' => 'elgg-button-action upload-btn'
	))?>
	<br/>
	<div class="images">
		<?php 
			foreach($image_ids as $image_id){ 				
		?>
			<div class="image">
				<a class="delete"></a>
				<img src="/gallery_field/image/<?=$image_id?>/small"/>
			</div>
		<?php 			
			} 
		?>
	</div>
	<br/>
	<?=elgg_view('input/button', array(
		'value' => elgg_echo('save'),
		'class' => 'elgg-button-submit'
	))?>	
	
	<?=elgg_view('input/button', array(
		'value' => elgg_echo('cancel'),
		'class' => 'elgg-button-cancel'
	))?>	
	<input type="hidden" <?=elgg_format_attributes($vars); ?> />
</div>
