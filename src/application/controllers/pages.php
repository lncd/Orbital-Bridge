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
		
			switch ($page->mode)
			{
			
				case 'page':
		
					$this->load->helper('markdown');
					
					$header['page'] = $slug;
					
					$data = array(
						'title' => $page->title,
						'content' => $page->content
					);
					
					$this->load->view('inc/head', $header);
					$this->load->view('pages/page', $data);
					$this->load->view('inc/foot');
					
					break;
					
				case 'git':
				
					if ($content = @file_get_contents($_SERVER['GITHUB_BASE_URI'] . '/master/' . $page->git_page)){
						
						$this->load->helper('markdown');
					
						$header['page'] = $slug;
						
						$data = array(
							'title' => $page->title,
							'content' => $content
						);
						
						$this->load->view('inc/head', $header);
						$this->load->view('pages/page', $data);
						$this->load->view('inc/foot');
						
					}
					else
					{
						$this->load->view('inc/head', $header);
						$this->load->view('pages/error');
						$this->load->view('inc/foot');
					}
					
					break;
					
				case 'redirect':
				
					redirect($page->redirect_uri);
					break;
					
				default:
				
					$this->load->view('inc/head', $header);
					$this->load->view('pages/error');
					$this->load->view('inc/foot');
					break;
			
			}
			
						
		}
		else
		{
			show_404();
		}
	}
}

// EOF