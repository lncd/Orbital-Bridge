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
		
		$a = new Application();
		
		$data['db_apps'] = $a->order_by('name')->get();
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/home', $data);
		$this->load->view('inc/foot');
	}
	
	public function scan()
	{
		$header = array(
			'page' => 'admin'
		);
		
		$this->load->helper('file');
		
		$app_files = get_filenames('application/bridge_applications');
		
		var_dump($app_files);
		
		foreach ($app_files as $app_file)
		{
		
			$name_segments = explode('.', $app_file);
			$app_name = strtolower($name_segments[0]);
		
			$this->load->library('../bridge_applications/' . $app_file, array(), $app_name);
			
			echo $this->$app_name->configuration;
		}
		
		/*
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/scan', $data);
		$this->load->view('inc/foot');
		
		*/
	}
}

// EOF