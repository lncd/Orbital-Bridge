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
			if (isset($project->end_date_unix) AND $project->end_date_unix !== NULL)
			{
				if ($project->end_date_unix > time())
				{
					$projects_active[] = $project;
					$gantt_array[] = '{
					"name": "' . $project->title . '",
					"values": [{
						"from": "/Date(' . $project->start_date_unix * 1000 . ')/",
						"to": "/Date(' . $project->end_date_unix * 1000 . ')/",
						"desc": "' . $project->title . '<br>Starts: ' . $project->start_date . '<br>Ends: ' . $project->end_date . '",
						"label": "' . $project->title . '",
						}
					]}';
				}
				else
				{
					$projects_inactive[] = $project;
				}
			}
			else
			{
				if ($project->end_date_unix > time())
				{
					$projects_active[] = $project;
					$gantt_array[] = '{
					"name": "' . $project->title . '",
					"values": [{
						"from": "/Date(' . $project->start_date_unix * 1000 . ')/",
						"to": "/Date(' . $project->end_date_unix * 1000 . ')/",
						"desc": "' . $project->title . '<br>Starts: ' . $project->start_date . '<br>Ends: ' . $project->end_date . '",
						"label": "' . $project->title . '",
						"customClass": "barFade"
						}
					]}';
				}
				else
				{
					$projects_inactive[] = $project;
				}
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
	
	public function project($project_id)
	{
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
		$projects = @file_get_contents($_SERVER['NUCLEUS_BASE_URI'].'research_projects/id/' . $project_id . '?access_token=' . $_SERVER['NUCLEUS_TOKEN']);
		
		if ($http_response_header[0] === 'HTTP/1.0 404 Not Found')
        {
        	show_404();
        }
        else
        {
	        $projects = json_decode($projects);
        }
		
		$data = array(
			'project' => $projects->result
			);
			
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/project', $data);
		$this->load->view('inc/foot');
	}
	
}

// EOF