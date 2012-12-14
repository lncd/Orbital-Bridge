<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends DataMapper {

	var $table = 'pages';
	
		var $has_many = array(
		'page_category_link' => array()
	);

}