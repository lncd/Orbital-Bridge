<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard_option extends DataMapper {

	var $table = 'wizard_options';
	
	var $has_one = array(
		'wizard_page' => array(),
		'destination_page' => array(
			'class' => 'wizard_page',
			'other_field' => 'wizard_source'
		)
	);

}