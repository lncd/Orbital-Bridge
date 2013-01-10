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
		
							
		$footer['javascript'] = '$(document).ready(function() {
			$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
			
			$(\'#funding_div\').hide();
			
			$("#project_type").change(function () {
				$(\'#funding_div\').toggle(\'blind\');
			})
			
		});';
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('project_title', 'Project Title', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_lead', 'Project Lead', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'trim|required|max_length[255]|min_length[3]');

		if ($this->form_validation->run())
		{

			$fields = '{
				"title" : "' . $this->input->post('project_title') . '",' .
				'"lead" : "' . $this->input->post('project_lead') . '",' .
				'"description" : "' . $this->input->post('project_description') . '",' .
				'"funded" : "';
				
				if ($this->input->post('project_type') === 'funded')
				{
					$fields .= '1",	
					"currency_id" : "' . $this->input->post('project_funding_currency') . '",' .
					'"funding_amount" : "' . $this->input->post('project_funding_amount') . '",';
				}
				else
				{
					$fields .= '0",';
				}			
					
				$fields .=
				'"start_date" : "' . $this->input->post('project_start_date') . '",' .
				'"end_date" : "' . $this->input->post('project_end_date') . '"' .
				'}';
			
			//POST to N2
			$response = json_decode($this->post_curl_request($_SERVER['NUCLEUS_BASE_URI'] . 'research_projects', $fields, 'Bearer ' . $_SERVER['NUCLEUS_TOKEN']));
			
			if ($response->error)
			{
				$header['flashmessage'] = $response->error_message;
				$header['flashmessagetype'] = 'error';
								
				$this->load->view('inc/head', $header);
				$this->load->view('projects/create_unfunded');
				$this->load->view('inc/foot', $footer);
			}
			else
			{
				$this->session->set_flashdata('message', 'Project created successfully! (Still in testing phase - you will not be able to see your project!)');
				$this->session->set_flashdata('message_type', 'success');
				
				redirect('projects');
			}
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('projects/create_unfunded');
			$this->load->view('inc/foot', $footer);
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
	

	/**
	 * Post CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url     URL to POST CURL request
	 * array  $fields  Fields send over CURL
	 *
	 * @return null
	 * @access public
	 */

	public function post_curl_request($url, $fields, $access_token)
	{
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $access_token));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}
}

// EOF