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
		
		$footer = array();
		
		$data['eprints_research_total'] = FALSE;
		
		if ($eprints_stats = @file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'eprints/stats?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&account=' . $this->session->userdata('user_employee_id')))
		{
			
			$eprints_data = json_decode($eprints_stats);
			
			$data['eprints_research_total'] = $eprints_data->results->total;
			$data['eprints_years'] = FALSE;
			$data['eprints_types'] = FALSE;
			$data['eprints_views'] = $eprints_data->results->views->total;
			
			$v_year = date('Y', strtotime('first day of this month'));
			$v_month = date('n', strtotime('first day of this month'));
			
			$v_year_prev = date('Y', strtotime('first day of last month'));
			$v_month_prev = date('n', strtotime('first day of last month'));
			
			if (isset($eprints_data->results->views->breakdown->{$v_year}->{$v_month}))
			{
				$data['eprints_views_month'] = $eprints_data->results->views->breakdown->{$v_year}->{$v_month};
			}
			else
			{
				$data['eprints_views_month'] = 0;
			}
			
			if (isset($eprints_data->results->views->breakdown->{$v_year}->{$v_month}))
			{
				$data['eprints_views_month_prev'] = $eprints_data->results->views->breakdown->{$v_year_prev}->{$v_month_prev};
			}
			else
			{
				$data['eprints_views_month_prev'] = 0;
			}
			
			$ep_years = array();
			
			$stats_years = (array) $eprints_data->results->publication_years;
			
			ksort($stats_years);
			
			foreach ($stats_years as $year => $value)
			{
				$data['eprints_years'] = TRUE;
				$ep_years[] = '{ y: \'' . $year . '\', a: ' . $value . ' }';
			}
			
			$ep_types = array();
			
			$stats_types = (array) $eprints_data->results->types;
			
			asort($stats_types);
			
			foreach ($stats_types as $type => $value)
			{
				$data['eprints_types'] = TRUE;
				$ep_types[] = '{ label: \'' . $type . '\', value: ' . $value . ' }';
			}
			
			if ($data['eprints_years'] OR $data['eprints_types'])
			{
			
				$footer['javascript'] = "Morris.Bar({
					element: 'eprints-output-history',
					data: [" . implode(',', $ep_years) . "],
					xkey: 'y',
					ykeys: ['a'],
					labels: ['Publications'],
					hideHover: true,
					barColors: [
						'#337C5C',
						'#59BB90',
						'#A2D8C0'
					]
				});
				
				Morris.Donut({
					element: 'eprints-types',
					data: [" . implode(',', $ep_types) . "],
					colors: [
						'#337C5C',
						'#59BB90',
						'#A2D8C0'
					]
				});";
				
			}
			
		}
		
		$this->load->view('inc/head', $header);
		$this->load->view('profile', $data);
		$this->load->view('inc/foot', $footer);
	}
}

// EOF