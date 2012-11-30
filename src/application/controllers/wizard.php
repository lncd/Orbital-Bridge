<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard extends CI_Controller {

	public function view($slug = 'start')
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
			'page' => 'wizard',
			'categories' => $categories,
			'category_pages' => $category_pages
		);
		
		$w = new Wizard_page();
		
		$page = $w->get_by_slug($slug);
		
		if ($page->result_count() === 1)
		{
		
			$this->load->library('typography');
			
			$options = array();
			
			foreach ($page->wizard_option->order_by('order')->get() as $option)
			{
				$destination = $option->destination_page->get();
				$options[] = array(
					'title' => $option->title,
					'text' => $option->text,
					'button' => $option->button,
					'slug' => $destination->slug
				);
			}
		
			$data = array(
				'title' => $page->title,
				'content' => $page->content,
				'options' => $options
			);
			
			$this->load->view('inc/head', $header);
			$this->load->view('wizard', $data);
			$this->load->view('inc/foot');
			
		}
		else
		{
			show_404();
		}
	}
}

// EOF