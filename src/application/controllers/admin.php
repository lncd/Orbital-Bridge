<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (! $this->session->userdata('user_admin') === TRUE)
		{
			show_404();
		}
	}

	public function index()
	{
		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/home');
		$this->load->view('inc/foot');
	}
	
	public function applications()
	{
		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$a = new Application();
		$data['db_apps'] = $a->order_by('name')->get();
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/applications', $data);
		$this->load->view('inc/foot');
	}
	
	public function recipes()
	{
		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/recipes');
		$this->load->view('inc/foot');
	}
	
	public function pages()
	{
		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$p = new Page();
		$data['pages'] = $p->order_by('title')->get();
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/pages', $data);
		$this->load->view('inc/foot');
	}
	
	public function page_categories()
	{
		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$c = new Page_category();
		$data['categories'] = $c->order_by('title')->get();
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/page_categories', $data);
		$this->load->view('inc/foot');
	}
	
	public function scan()
	{		
		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->helper('file');
		
		$app_files = get_filenames('application/bridge_applications');
		
		foreach ($app_files as $app_file)
		{
		
			$name_segments = explode('.', $app_file);
			$app_name = strtolower($name_segments[0]);
		
			$this->load->library('../bridge_applications/' . $app_file, array(), $app_name);
			
			$error = FALSE;
			$error_message = NULL;
			
			$app_display_name = 'bridge_applications/' . $app_file;
			
			// Configuration sanity testing mode, ENGAGE!
			
			try
			{
			
				// Does this app have a configuration variable?
			
				if (!isset($this->$app_name->configuration))
				{
					throw new Exception ('This application does not have a configuration variable, and cannot be installed.');
				}
				
				// Does this app's config variable actually parse?
				
				if (! $config = json_decode($this->$app_name->configuration))
				{
					throw new Exception ('This application\'s configuration variable is not valid JSON, and cannot be parsed. This application cannot be installed.');
					
				}
				
				if (isset($config->name))
				{
					$app_display_name = $config->name;
				}
				else
				{
					throw new Exception ('This application\'s configuration does not include a name.');
				}
			
			}
			catch (Exception $e)
			{
				$error = TRUE;
				$error_message = $e->getMessage();
			}
			
			$discovered[$app_name] = array(
				'name'			=> $app_display_name,
				'filename'		=> $app_file,
				'error'			=> $error,
				'error_message'	=> $error_message
			);
		}
		
		$data['discovered'] = $discovered;
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/scan', $data);
		$this->load->view('inc/foot');

	}
	
	public function page($id = NULL)
	{
		if($id === NULL)
		{
			show_404();
		}
		$p = new Page();
		if($p->where('id', $id)->count() > 0)
		{
			$pages = $p->where('id', $id)->get();
		}
		else
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');


		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$a = new Application();
		
		$data['db_apps'] = $a->order_by('name')->get();
		$data['page_data'] = $pages;
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		$this->form_validation->set_rules('page_content', 'Page Content', 'required');
		$this->form_validation->set_rules('page_slug', 'Page URL', 'required');
		
		if ($this->form_validation->run())
		{
			$p = new Page();
			$p->where('id', $id)->get();
			$p->title = $this->input->post('page_title');
			$p->content = $this->input->post('page_content');
			$p->slug = $this->input->post('page_slug');
			$p->save();
			$this->session->set_flashdata('message', 'Page updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_edit', $data);
			$this->load->view('inc/foot');
		}	
	}
	
	public function delete_page($id = NULL)
	{	
		if($id === NULL)
		{
			show_404();
		}
		$p = new Page();
		if($p->where('id', $id)->count() > 0)
		{
			$pages = $p->where('id', $id)->get();
		}
		else
		{
			show_404();
		}
		$this->load->helper('form');
		$this->load->library('form_validation');

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$data['page_data'] = $pages;		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('page_title', 'Page Title', 'callback_page_title_check[' . $pages->title . ']');
		$this->form_validation->set_message('page_title_check', 'You did not type the correct page title');
		
		if ($this->form_validation->run())
		{
			$p = new Page();
			$p->where('id', $id)->get();
			$p->delete();
			$this->session->set_flashdata('message', 'Page Deleted');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_delete', $data);
			$this->load->view('inc/foot');
		}	
	}

	public function page_title_check($str, $page_title)
	{
		if ($str == $page_title)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function page_category($id = NULL)
	{
		if($id === NULL)
		{
			show_404();
		}
		
		$c = new Page_category();
		if($c->where('id', $id)->count() > 0)
		{
			$categories = $c->where('id', $id)->get();
		}
		else
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$p = new Page();
		$p->where('id', $id);
		$pages = $p->get();

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$a = new Application();
		
		
		$data['db_apps'] = $a->order_by('name')->get();
		$data['category_data'] = $categories;
		$data['pages'] = $this->bridge->pages();
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('category_title', 'Category Title', 'required');
		$this->form_validation->set_rules('category_slug', 'Category URL', 'required');
		
		$c = new Page_category();
		$c->where('id', $id)->get();
		
		if ($this->form_validation->run())
		{
			$c->title = $this->input->post('category_title');
			$c->slug = $this->input->post('category_slug');
			
			$page_cat_link = new Page_category_link();
			$page_cat_link->where('page_category_id', $id)->get();
			$page_cat_link->delete();
			
			if ($this->input->post('pages'))
			{
				
				foreach($this->input->post('pages') as $new_page)
				{
					$page_object = new Page();
					$page_object->where('id', $new_page)->get();
					$new_page_cat_link = new Page_category_link();
					$new_page_cat_link->order = 0;
					$new_page_cat_link->save(array('page_category' => $c, 'page' => $page_object));
				}
			}
			$this->session->set_flashdata('message', 'Category updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_category_edit', $data);
			$this->load->view('inc/foot');
		}	
	}
	
	public function delete_page_category($id = NULL)
	{
		if($id === NULL)
		{
			show_404();
		}
		
		$c = new Page_category();
		if($c->where('id', $id)->count() > 0)
		{
			$categories = $c->where('id', $id)->get();
		}
		else
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$p = new Page();
		$p->where('id', $id);
		$pages = $p->get();

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		
		$data['page_category_data'] = $categories;		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('page_category_title', 'Category Title', 'callback_page_category_title_check[' . $categories->title . ']');
		$this->form_validation->set_message('page_category_title_check', 'You did not type the correct category title');
		
		if ($this->form_validation->run())
		{
			$c = new Page_category();
			$c->where('id', $id)->get();
			$c->delete();
			$this->session->set_flashdata('message', 'Category Deleted');
			$this->session->set_flashdata('message_type', 'success');
			redirect('admin');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_category_delete', $data);
			$this->load->view('inc/foot');
		}	
	}

	public function page_category_title_check($str, $category_title)
	{
		if ($str == $category_title)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

// EOF