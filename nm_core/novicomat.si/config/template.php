<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


$template['active_template'] = 'master';

$templates = array();
array_push($templates,"auth");
array_push($templates,"master");

foreach($templates as $name) {
	$template[$name]['template'] = $name.'/_template';
	
	$template[$name]['regions'] = array(
		'title',
		'header',
		'panel',
		'content',
		'sidebar',
		'footer',
	);
	
	$template[$name]['parser'] = 'parser';
	$template[$name]['parser_method'] = 'parse';
	$template[$name]['parse_template'] = FALSE;
}
