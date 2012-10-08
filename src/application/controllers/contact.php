<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{
	
		$header = array(
			'page' => 'contact',
			'title' => 'Contact Us'
		);
	
		$this->load->view('inc/head', $header);
		$this->load->view('contact');
		$this->load->view('inc/foot');
	}
}

// EOF