<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_category_link extends DataMapper {

	var $table = 'page_category_links';
	
		var $has_one = array(
		'page' => array(),
		'page_category' => array()
	);
}