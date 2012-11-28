<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {
	
	public function my()
	{
	
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
	
		$header = array(
			'page' => 'me'
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/my');
		$this->load->view('inc/foot');
	}
	
	public function start()
	{
	
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
	
		$header = array(
			'page' => 'projects'
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/start');
		$this->load->view('inc/foot');
	}
	
}

// EOF