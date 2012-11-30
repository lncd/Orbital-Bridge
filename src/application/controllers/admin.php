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
			'page' => 'admin',
			'categories' => $categories,
			'category_pages' => $category_pages
		);
		
		$a = new Application();
		
		$data['db_apps'] = $a->order_by('name')->get();
		$data['categories'] = $categories;
		$data['category_pages'] = $category_pages;
		
		$this->load->view('inc/head', $header);
		$this->load->view('admin/home', $data);
		$this->load->view('inc/foot');
	}
	
	public function scan()
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
			'page' => 'admin',
			'categories' => $categories,
			'category_pages' => $category_pages
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
}

// EOF