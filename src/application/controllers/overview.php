<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Overview extends CI_Controller {

	public function eprints()
	{
	
		$header = array(
			'page' => 'overview',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$footer = array();
		
		$data['eprints_research_total'] = FALSE;
		
		if ($eprints_stats = @file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'eprints/stats?access_token=' . $_SERVER['NUCLEUS_TOKEN']))
		{
			
			$eprints_data = json_decode($eprints_stats);
			
			$data['eprints_research_total'] = $eprints_data->results->total;
			$data['eprints_views'] = $eprints_data->results->views->total;
			
			
			$ep_years = array();
			
			$stats_years = (array) $eprints_data->results->publication_years;
			
			ksort($stats_years);
			
			foreach ($stats_years as $year => $value)
			{
				$ep_years[] = '{ y: \'' . $year . '\', a: ' . $value . ' }';
			}
			
			
			$ep_types = array();
			
			$stats_types = (array) $eprints_data->results->types;
			
			asort($stats_types);
			
			foreach ($stats_types as $type => $value)
			{
				$ep_types[] = '{ label: \'' . $type . '\', value: ' . $value . ' }';
			}
			
			
			foreach ($eprints_data->results->views->breakdown as $views_year => $year_values)
			{
				
				foreach ($year_values as $views_month => $value)
				{
					$views_breakdown[] = '{ y: \'' . $views_year . '-' . $views_month . '\', a: ' . $value . ' }';
				}
			}
			
			
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
			});
			
			Morris.Line({
				element: 'eprints-views-history',
				data: [" . implode(',', $views_breakdown) . "],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['Views'],
				hideHover: true,
				lineColors: [
					'#337C5C',
					'#59BB90',
					'#A2D8C0'
				]
			});";
			
		}
		
		$this->load->view('inc/head', $header);
		$this->load->view('overview/eprints', $data);
		$this->load->view('inc/foot', $footer);
	}
}

// EOF