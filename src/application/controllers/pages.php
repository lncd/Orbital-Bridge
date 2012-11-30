<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view($slug)
	{
		$p_c = new Page_category();
		$categories = $p_c->get();
		
		foreach($categories as $category)
		{
			$p = new Page();
			$p->where_related_page_category_link('page_category_id', $category->id);
			$p->order_by('order');
			$pages = $p->get();
			$category_pages[$category->id] = $pages;
		}
		
		$header = array(
			'page' => 'page',
			'categories' => $categories,
			'category_pages' => $category_pages
		);
		
		$p = new Page();
		
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