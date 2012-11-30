<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
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
			'page' => 'home',
			'categories' => $categories,
			'category_pages' => $category_pages
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('home');
		$this->load->view('inc/foot');
	}
}

// EOF