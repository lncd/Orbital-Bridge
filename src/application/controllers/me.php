<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Me extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
	}

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
			'page' => 'me',
			'categories' => $categories,
			'category_pages' => $category_pages
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('me/me');
		$this->load->view('inc/foot');
	}
}

// EOF