<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard extends CI_Controller {

	public function view($slug = 'start')
	{
		$header = array(
			'page' => 'wizard'
		);
		
		$w = new Wizard_page();
		
		$page = $w->get_by_slug($slug);
		
		if ($page->result_count() === 1)
		{
		
			$this->load->library('typography');
			
			foreach ($page->wizard_option->order_by('order')->get() as $option)
			{
				$options[] = array(
					'title' => $option->title,
					'text' => $option->text,
					'button' => $option->button
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