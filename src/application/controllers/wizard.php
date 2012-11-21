<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard extends CI_Controller {

	public function view($page = 'start')
	{
		$header = array(
			'page' => 'wizard'
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('wizard');
		$this->load->view('inc/foot');
	}
}

// EOF