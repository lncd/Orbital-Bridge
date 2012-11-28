<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard_page extends DataMapper {

	var $table = 'wizard_pages';
	
	var $validation = array(
		'slug' => array(
			'label' => 'Slug',
			'rules' => array('required')
		),
		'title' => array(
			'label' => 'Title',
			'rules' => array('required')
		),
		'content' => array(
			'label' => 'Content',
			'rules' => array('required')
		)
	);
	
	var $has_many = array(
		'wizard_option' => array(),
		'wizard_source' => array(
			'class' => 'wizard_option',
			'other_field' => 'destination_page'
		)
	);

}