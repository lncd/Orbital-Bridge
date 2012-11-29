<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function view($slug)
	{
		$header = array(
			'page' => 'page'
		);
		
		$p = new Pages();
		
		$page = $p->get_by_slug($slug);
		
		if ($page->result_count() === 1)
		{		
			$this->load->library('typography');
			
			$data = array(
				'title' => $page->title,
				'content' => $page->content
			);
			
			$this->load->view('inc/head', $header);
			$this->load->view('pages', $data);
			$this->load->view('inc/foot');			
		}
		else
		{
			show_404();
		}
	}
}

// EOF