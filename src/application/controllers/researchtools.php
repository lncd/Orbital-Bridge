<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Researchtools extends CI_Controller {

	public function index()
	{
		$header = array(
			'page' => 'tools',
			'title' => 'Tools'
		);
	
		$this->load->view('inc/head', $header);
		$this->load->view('tools');
		$this->load->view('inc/foot');
	}
}

// EOF