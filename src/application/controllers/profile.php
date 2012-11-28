<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
	}

	public function index()
	{
		$header = array(
			'page' => 'me'
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('profile');
		$this->load->view('inc/foot');
	}
}

// EOF