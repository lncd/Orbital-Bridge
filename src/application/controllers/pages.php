<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view($slug)
	{
		
		$header = array(
			'page' => 'page',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$p = new Page();
		
		$page = $p->get_by_slug($slug);
		
		if ($page->result_count() === 1)
		{		
			$this->load->helper('markdown');
			
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