<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$header = array(
			'page' => 'home'
		);
		
		/*
		$this->load->library('sword');
		$sword_input = $this->sword->input('http://www.ukoln.ac.uk/repositories/sword/test-import.xml');
		$this->load->library('ckan');
		$this->ckan->create_dataset($sword_input, '62935967-73a5-474c-9ab3-22c849bbd1cd');
		*/
		
		$this->load->library('ckan');
		$ckan_dataset = $this->ckan->input('https://ckan.lincoln.ac.uk/api/rest/dataset/on_testing_the_atom_protocol');		
		$this->load->library('sword');
		var_dump($this->sword->create($ckan_dataset));
		
		$this->load->view('inc/head', $header);
		$this->load->view('home');
		$this->load->view('inc/foot');
	}
}

// EOF