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
		
		$a = new Application();
		
		$data['db_apps'] = $a->order_by('name')->get();
		
		$p = new Page();
		$data['pages'] = $p->order_by('title')->get();
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/home', $data);
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
				
				var_dump ($config);
			
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
	
	public function page($id)
	{
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
			redirect('admin');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_edit', $data);
			$this->load->view('inc/foot');
		}	
	}
	
	public function delete_page($id)
	{
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
}

// EOF