<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (! $this->session->userdata('user_admin') === TRUE)
		{
			show_404();
		}
		
	}

	public function index()
	{
		$header = array(
			'page' => 'admin'
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/home');
		$this->load->view('inc/foot');
	}
}

// EOF