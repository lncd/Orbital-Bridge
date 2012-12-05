<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
	
		$header = array(
			'page' => 'me',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$footer['javascript'] = "Morris.Bar({
			element: 'eprints-output-history',
			data: [
				{ y: '2002', a: 1 },
				{ y: '2008', a: 1 },
				{ y: '2009', a: 2 },
				{ y: '2010', a: 3 },
				{ y: '2011', a: 1 },
				{ y: '2012', a: 2 }
			],
			xkey: 'y',
			ykeys: ['a'],
			labels: ['Publications'],
			hideHover: true
		});
		
		Morris.Donut({
			element: 'eprints-types',
			data: [
				{ label: 'Article', value: 2 },
				{ label: 'Book Section', value: 4 },
				{ label: 'Conference or Workshop Item (Other)', value: 2 },
				{ label: 'Conference or Workshop Item (Paper)', value: 3 },
				{ label: 'Conference or Workshop Item (Poster)', value: 2 },
				{ label: 'Teaching Resource', value: 1 },
				{ label: 'Thesis (Masters)', value: 1 }
			]
		});";
		
		$this->load->view('inc/head', $header);
		$this->load->view('profile');
		$this->load->view('inc/foot', $footer);
	}
}

// EOF