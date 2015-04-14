<?php 
	
$plugin = $vars["entity"];


echo '<div>';
echo elgg_echo('gallery_field:enable_blog');
echo ' ';
echo elgg_view('input/select', array(
	'name' => 'params[enable_blog]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $vars['entity']->enable_blog,
));
echo '</div>';

echo '<div>';
echo elgg_echo('gallery_field:enable_pages');
echo ' ';
echo elgg_view('input/select', array(
	'name' => 'params[enable_pages]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $vars['entity']->enable_pages,
));
echo '</div>';