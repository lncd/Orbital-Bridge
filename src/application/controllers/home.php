<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$header = array(
			'page' => 'home'
		);
		
		$this->load->library('OAI');
		echo'<pre>';print_r($this->oai->display_OAI_PMH());echo'</pre>';
		
		$this->load->view('inc/head', $header);
		$this->load->view('home');
		$this->load->view('inc/foot');
	}
}

// EOF