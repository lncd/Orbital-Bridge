<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmp extends CI_Controller {
	
	public function index()
	{
		$this->load->library('dmponline_api');
		var_dump($this->dmponline_api->request_api_key('hnewton@lincoln.ac.uk', 'testpassword'));
		
		$header = array(
			'page' => 'home',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$this->load->view('inc/head', $header);
		$this->load->view('dmp');
		$this->load->view('inc/foot');
	}	
}