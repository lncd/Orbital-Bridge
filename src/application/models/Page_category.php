<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_category extends DataMapper {

	var $table = 'page_categories';
	
		var $has_many = array(
		'page_category_link' => array()
	);
}