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
		
		$projects = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'].'research_projects?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&account=' . $this->session->userdata('user_id')));

		$projects_active = array();
		$projects_inactive = array();
		
		$total_funding = 0;
		
		foreach ($projects->results as $project)
		{
			if ($project->end_date_unix > time() OR $project->end_date_unix === NULL)
			{
				$projects_active[] = $project;
				if ($project->end_date_unix === NULL)
				{
					$project->end_date_unix = time() + 604800;
					$class = 'barFade';
				}
				else
				{
					$class = '';
				}
				$gantt_array[] = '{
				"name": "' . $project->title . '",
				"values": [{
					"from": "/Date(' . $project->start_date_unix * 1000 . ')/",
					"to": "/Date(' . $project->end_date_unix * 1000 . ')/",
					"desc": "' . $project->title . '<br>Starts: ' . $project->start_date . '<br>Ends: ' . $project->end_date . '",
					"label": "' . $project->title . '",
					"customClass": "' . $class . '"
					}
				]}';
			}
			else
			{
				$projects_inactive[] = $project;
			}
			
			if ($project->funding !== NULL AND $project->funding->currency_name === 'Sterling')
			{
				$total_funding += $project->funding->amount;
			}
		}
		
		$data = array(
			'active' => $projects_active,
			'inactive' => $projects_inactive,
			'total_projects' => count($projects_active) + count($projects_inactive),
			'total_current_projects' => count($projects_active),
			'total_funding' => $total_funding
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
	
	public function create_unfunded()
	{	
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('project_title', 'Project Title', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_lead', 'Project Lead', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'trim|required|max_length[255]|min_length[3]');

		if ($this->form_validation->run())
		{
			$this->session->set_flashdata('message', 'Project created successfully! (Project not really created, this is just a test!)');
			$this->session->set_flashdata('message_type', 'success');

			redirect('projects');
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('projects/create_unfunded');
			$this->load->view('inc/foot');
		}
		
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