<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$header = array(
			'page' => 'home'
		);
		
		$this->load->library('ckan');
		echo'<pre>';print_r($this->ckan->read('https://ckan.lincoln.ac.uk/api/rest/dataset/course-data'));echo'</pre>';
		
		$this->load->view('inc/head', $header);
		$this->load->view('home');
		$this->load->view('inc/foot');
	}
}

// EOF