<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (! $this->session->userdata('user_admin') === TRUE)
		{
			$header = array(
				'page' => 'admin',
				'categories' => $this->bridge->categories(),
				'category_pages' => $this->bridge->category_pages()
			);

			$this->load->view('inc/head', $header);
			$this->load->view('admin/error');
			$this->load->view('inc/foot');

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
		
		$footer = array(
			'javascript' => '$("#page_content").markItUp(markdownSettings);'
		);

		$a = new Application();

		$data['db_apps'] = $a->order_by('name')->get();
		$data['page_data'] = $pages;


		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('page_title', 'page_title', 'trim|required|max_length[128]|min_length[1]|callback_page_title_edit_check[' . $pages->id . ']');
		if ($pages->protected == 0)
		{
			$this->form_validation->set_rules('page_slug', 'page_slug', 'trim|required|alpha_dash|max_length[128]|min_length[1]|callback_page_slug_edit_check[' . $pages->id . ']');
		}
		$this->form_validation->set_rules('page_type', 'Page Type', 'required');

		if ($this->form_validation->run())
		{
			$p = new Page();
			$p->where('id', $id)->get();
			$p->title = $this->input->post('page_title');
			$p->mode = $this->input->post('page_type');
			$p->content = $this->input->post('page_content') != '' ? $this->input->post('page_content') : NULL;
			$p->git_page = $this->input->post('page_git_page') != '' ? $this->input->post('page_git_page') : NULL;
			$p->redirect_uri = $this->input->post('page_redirect_uri') != '' ? $this->input->post('page_redirect_uri') : NULL;
			if ($this->input->post('slug')) { $p->slug = $this->input->post('page_slug'); }
			$p->save();
			$this->session->set_flashdata('message', 'Page updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin/pages');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_edit', $data);
			$this->load->view('inc/foot', $footer);
		}
	}

	public function page_title_edit_check($str, $id)
	{
		$p = new Page();
		$p->where('id !=', $id);
		$count_test = $p->where('title', $str)->count();
		
		if ($count_test === 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function page_slug_edit_check($str, $id)
	{
		$p = new Page();
		$p->where('id !=', $id);
		$count_test = $p->where('slug', $str)->count();
		
		if ($count_test === 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function add_page()
	{
		$p = new Page();

		$this->load->helper('form');
		$this->load->library('form_validation');

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$footer = array(
			'javascript' => '$("#page_content").markItUp(markdownSettings);'
		);

		$a = new Application();

		$data['db_apps'] = $a->order_by('name')->get();


		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('page_title', 'Page Title', 'required');
		$this->form_validation->set_rules('page_type', 'Page Type', 'required');
		$this->form_validation->set_rules('page_slug', 'Page URL', 'required');

		if ($this->form_validation->run())
		{
			$p = new Page();
			$p->title = $this->input->post('page_title');
			$p->mode = $this->input->post('page_type');
			$p->slug = $this->input->post('page_slug');
			$p->content = $this->input->post('page_content') != '' ? $this->input->post('page_content') : NULL;
			$p->git_page = $this->input->post('page_git_page') != '' ? $this->input->post('page_git_page') : NULL;
			$p->redirect_uri = $this->input->post('page_redirect_uri') != '' ? $this->input->post('page_redirect_uri') : NULL;
			$p->save();
			$this->session->set_flashdata('message', 'Page updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin/pages');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_add', $data);
			$this->load->view('inc/foot', $footer);
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

			redirect('admin/pages');
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

	public function add_category()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$footer = array(
			'javascript' => '$("#page_content").markItUp(markdownSettings);'
		);

		$a = new Application();

		$data['db_apps'] = $a->order_by('name')->get();


		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('category_title', 'category_title', 'trim|required|alpha_dash|max_length[128]|min_length[1]|is_unique[page_categories.title]');
		$this->form_validation->set_rules('category_slug', 'category_slug', 'trim|required|alpha_dash|max_length[128]|min_length[1]|is_unique[page_categories.slug]');


		if ($this->form_validation->run())
		{
			$p_c = new Page_category();
			$num_cats = $p_c->count();
			$p_c->title = $this->input->post('category_title');
			$p_c->slug = $this->input->post('category_slug');
			$p_c->order = $num_cats + 1;
			$p_c->active = (bool) $this->input->post('category_active');
			$p_c->icon = $this->input->post('category_icon');
			$p_c->save();
			$this->session->set_flashdata('message', 'Page updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin/page_categories');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_category_add', $data);
			$this->load->view('inc/foot', $footer);
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

		//The javscript for the sortable list of pages.
		$footer = array(
			'javascript' => '$(function() {
				$( "#sortable1, #sortable2" ).sortable({
					connectWith: ".connectedSortable",
						update: function( event, ui ) {
						$("#pages_list").val($("#sortable1").sortable("toArray"));
					}
				}).disableSelection();	
			});'
		);

		$a = new Application();

		$p_c_l = new Page_category_link();
		$page_category_pages_checked = $p_c_l->where('page_category_id', $id)->get();

		foreach($page_category_pages_checked as $page_category_page_checked)
		{
			$data['page_category_page_checked'][] = $page_category_page_checked->page_id;
		}

		$data['db_apps'] = $a->order_by('name')->get();
		$data['category_data'] = $categories;
		$data['pages'] = $this->bridge->pages();

		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('category_title', 'category_title', 'trim|required|alpha_dash|max_length[128]|min_length[1]|callback_category_title_check[' . $categories->id . ']');
		$this->form_validation->set_rules('category_slug', 'category_slug', 'trim|required|alpha_dash|max_length[128]|min_length[1]|callback_category_slug_check[' . $categories->id . ']');

		$c = new Page_category();
		$c->where('id', $id)->get();

		if ($this->form_validation->run())
		{
			$c->title = $this->input->post('category_title');
			$c->slug = $this->input->post('category_slug');
			
			if ($this->input->post('category_active'))
			{
				$c->active = TRUE;
			}
			else
			{
				$c->active = FALSE;
			}

			$page_cat_links = new Page_category_link();
			$page_cat_links->where('page_category_id', $id)->get();
			foreach ($page_cat_links as $page_cat_link)
			{
				$page_cat_link->delete();
			}

			if ($this->input->post('pages_list'))
			{
				$pages_array = explode(',', $this->input->post('pages_list'));
				$order = 1;
				foreach($pages_array as $new_page)
				{
					$page_object = new Page();
					$page_object->where('id', $new_page)->get();
					$new_page_cat_link = new Page_category_link();
					$new_page_cat_link->order = $order;
					$new_page_cat_link->save(array('page_category' => $c, 'page' => $page_object));
					$order++;
				}
			}
			
			$c->save();
			
			$this->session->set_flashdata('message', 'Category updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin/page_categories');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_category_edit', $data);
			$this->load->view('inc/foot', $footer);
		}
	}
	

	public function category_title_check($str, $id)
	{
		$c = new Page_category();
		$c->where('id !=', $id);
		$count_test = $c->where('title', $str)->count();
		
		if ($count_test === 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('category_title_check', 'This category title is already in use.');
			return FALSE;
		}
	}
	public function category_slug_check($str, $id)
	{
		$c = new Page_category();
		$c->where('id !=', $id);
		$count_test = $c->where('title', $str)->count();
		
		if ($count_test === 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('category_slug_check', 'This category URL is already in use');
			return FALSE;
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

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$data['page_category_data'] = $categories;

		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('category_title', 'Category Title', 'callback_page_category_title_check[' . $categories->title . ']');
		$this->form_validation->set_message('page_category_title_check', 'You did not type the correct category title');

		if ($this->form_validation->run())
		{
			$c = new Page_category();
			$c->where('id', $id)->get();
			$c->delete();
			$this->session->set_flashdata('message', 'Category Deleted');
			$this->session->set_flashdata('message_type', 'success');
			redirect('admin/page_categories');
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

	public function order_page_categories()
	{
		$c = new Page_category();
		$categories = $c->get();

		$this->load->helper('form');
		$this->load->library('form_validation');

		$header = array(
			'page' => 'admin',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		//The javscript for the sortable list of pages.
		$footer = array(
			'javascript' => '$(function() {
				$( "#sortable1" ).sortable({
					update: function( event, ui ) {
						$("#pages_list").val($("#sortable1").sortable("toArray"));
					}
				}).disableSelection();
			});'
		);

		$a = new Application();

		$data['categories'] = $this->bridge->categories();

		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('pages_list', 'Categories have not been changed. The Pages List', 'required');
		if ($this->form_validation->run())
		{
			$categories_array = explode(',', $this->input->post('pages_list'));
			$order = 1;
			foreach($categories_array as $category)
			{
				$category_object = new Page_category();
				$category_object->where('id', $category)->get();
				$category_object->order = $order;
				$category_object->save();
				$order++;				
			}
			
			$c->save();
			
			$this->session->set_flashdata('message', 'Category updated');
			$this->session->set_flashdata('message_type', 'success');

			redirect('admin/page_categories');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('admin/page_categories_order', $data);
			$this->load->view('inc/foot', $footer);
		}
	}
}

// EOF