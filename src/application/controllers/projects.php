<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {
	
	public function my()
	{
	
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
		$header = array(
			'page' => 'me',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$gantt_array = array();
		
		$projects = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'].'research_projects?access_token=' . $_SERVER['NUCLEUS_TOKEN']));
		
		$projects_active = array();
		$projects_inactive = array();
		
		foreach ($projects->results as $project)
		{
			if ($project->end_date_unix > time())
			{
				$projects_active[] = $project;
				$gantt_array[] = '{
				"name": "' . $project->title . '",
				"values": [{
					"from": "/Date(' . $project->start_date_unix * 1000 . ')/",
					"to": "/Date(' . $project->end_date_unix * 1000 . ')/",
					"desc": "' . $project->title . '",
					"label": "' . $project->title . '",
					"customClass": "ganttRed"}
					]}';
			}
			else
			{
				$projects_inactive[] = $project;
			}
		}
		
		$data = array(
			'active' => $projects_active,
			'inactive' => $projects_inactive
			);
					
		$footer['javascript'] = '$("#inactive_button").click(function () {
			$(\'#inactive\').toggle(\'blind\');
			});
			
			$("#projectsTimeline").gantt({
			source: [' .implode(',', $gantt_array) . '],
			scale: "weeks",
			minScale: "weeks",
			maxScale: "months"
});

';
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/my', $data);
		$this->load->view('inc/foot', $footer);
	}
	
	public function start()
	{
	
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/start');
		$this->load->view('inc/foot');
	}
	
}

// EOF