<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin?destination=' . urlencode(current_url()));
		}
		
	}
	
	public function my()
	{
		
		$header = array(
			'page' => 'me',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$gantt_array = array();

		$projects = $this->n2->GetResearchProjects($this->session->userdata('access_token'), array("account" => $this->session->userdata('user_employee_id')));
		$projects_active = array();
		$projects_inactive = array();			
		$total_funding = array();
					
		foreach ($projects['results'] as $project)
		{
			if ($project['research_project_status']['type'] === 'archived')
			{
				$projects_inactive[] = $project;
			}
			else
			{
				$projects_active[] = $project;
				if ($project['end_date_unix'] === NULL)
				{
					$project['end_date_unix'] = time() + 604800;
					$class = 'barFade';
				}
				else
				{
					$class = '';
				}
				$gantt_array[] = '{
				"name": "' . $project['title'] . '",
				"values": [{
					"from": "/Date(' . $project['start_date_unix'] * 1000 . ')/",
					"to": "/Date(' . $project['end_date_unix'] * 1000 . ')/",
					"desc": "' . $project['title'] . '<br>Starts: ' . $project['start_date'] . '<br>Ends: ' . $project['end_date'] . '",
					"label": "' . $project['title'] . '",
					"customClass": "' . $class . '"
					}
				]}';
			}
			
			if ($project['funding_amount'] !== NULL AND $project['ams_success'] === 'Successful' AND $project['research_project_status']['text'] !== 'Deleted')
			{
				if(isset($total_funding[$project['funding_currency']['id']]))
				{
					$total_funding[$project['funding_currency']['id']]['value'] = $total_funding[$project['funding_currency']['id']]['value'] + $project['funding_amount'];
				}
				else
				{
					$total_funding[$project['funding_currency']['id']] = array('symbol' => $project['funding_currency']['symbol'], 'value' => $project['funding_amount']);
				}
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
		
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$this->load->view('inc/head', $header);
		$this->load->view('projects/start');
		$this->load->view('inc/foot');
	}
	
	public function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);

		$footer['javascript'] = '$(document).ready(function() {
			$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
		});';
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('project_title', 'Project Title', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'trim|required');

		if ($this->form_validation->run())
		{
			$fields['title'] = $this->input->post('project_title');
			if($this->input->post('project_description'))
			{
				$fields['summary'] = $this->input->post('project_description');
			}
			$fields['description'] = $this->input->post('project_description');

			$fields['start_date'] = $this->input->post('project_start_date');
			if($this->input->post('project_end_date') !== NULL AND $this->input->post('project_end_date') !== '')
			{
				$fields['end_date'] = $this->input->post('project_end_date');
			}
			else
			{
				$fields['end_date'] = NULL;
			}

			if($this->input->post('project_website'))
			{
				$fields['website'] = $this->input->post('project_website');
			}
				
			$members[] = array('person_id' => (int) $this->session->userdata('user_id'), 'permission_id' => (int) 2);

			$fields['project_members'] = $members;
			
			$fields['research_project_status_id'] = 18;

			//POST to N2

			try
			{
				$curl_response = $this->n2->CreateResearchProject($this->session->userdata('access_token'), $fields);
				
				$this->session->set_flashdata('message', 'Project created');
				$this->session->set_flashdata('message_type', 'success');
				
				redirect('projects');
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message', $e->getMessage());
				$this->session->set_flashdata('message_type', 'error');
												
				$this->load->view('inc/head', $header);
				$this->load->view('projects/create');
				$this->load->view('inc/foot', $footer);
			}
		}
		else
		{
			$this->load->view('inc/head', $header);
			$this->load->view('projects/create');
			$this->load->view('inc/foot', $footer);
		}		
	}
	
	public function project($project_id)
	{
		$this->load->helper('markdown');
		
		try
		{
			$project = $this->n2->GetResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id));
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'Unable to get project');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');			
		}

		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$data = array(
			'project' => $project['result']
			);

		$this->load->view('inc/head', $header);
		$this->load->view('projects/project', $data);
		$this->load->view('inc/foot');
	}

	public function create_ckan_group($project_id)
	{
		try
		{
			$project = $this->n2->GetResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id));
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'Unable to get project details');
			$this->session->set_flashdata('message_type', 'error');
			redirect('projects');			
		}
		
		if ( ! (bool) $project['result']['ckan_group_id'])
		{
			if ($project['result']['current_user_permission'] !== 'Administrator')
	        {
				$this->load->view('inc/head', $header);
				$this->load->view('projects/unauthorised');
				$this->load->view('inc/foot');
	        }
	        else
	        {        
				$this->load->library('../bridge_applications/ckan');

				$members = array(array('name' => 'orbital', 'capacity' => 'admin'));

				foreach($project['result']['research_project_members'] as $member)
				{
					$members[] = array('name' => $member['person']['sam_id'], 'capacity' => 'admin');
				}
				$result = json_decode($this->ckan->create_group(url_title($project['result']['title'], '-', TRUE), $project['result']['title'], $project['result']['summary'], $members));
				if($result->success === true)
				{
					try
					{
						$fields['id'] = (int) $project_id;
						$fields['ckan_group_id'] = $result->result->id;
						$curl_response = $this->n2->EditResearchProject($this->session->userdata('access_token'), $fields);
					}
					catch(Exception $e)
					{
						$this->session->set_flashdata('message', 'Project environment created, but: ' . $e->getMessage());
						$this->session->set_flashdata('message_type', 'warning');
						
						redirect('projects');
					}
					$this->session->set_flashdata('message', 'A group has been created in CKAN, the University\'s research data repository, for you to store this project\'s research data in. Any data created in this group will be automatically connected to this project.');
					$this->session->set_flashdata('message_type', 'success');
					
					redirect('project/' . $project_id);
				}
				else
				{
					$this->session->set_flashdata('message', $result->error->name[0]);
					$this->session->set_flashdata('message_type', 'error');
					redirect('project/' . $project_id);
				}
	        }
        }
        else
        {
			$this->session->set_flashdata('message', 'Project environment already exists in database');
			$this->session->set_flashdata('message_type', 'error');
			redirect('project/' . $project_id);			
		}
	}
	
	public function edit($project_id)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		try
		{
			$project = $this->n2->GetResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id));
			$permissions = $this->n2->GetResearchProjectPermissions($this->session->userdata('access_token'), array("id" => (int) $project_id));
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'Unable to get project details');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');			
		}		
        
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		if ($project['result']['current_user_permission'] !== 'Administrator')
        {
			$this->load->view('inc/head', $header);
			$this->load->view('projects/unauthorised');
			$this->load->view('inc/foot');
        }
        else
        {
        	$num_project_members = count($project['result']['research_project_members']);
        
        	$tags = null;
        
			$data = array(
				'project' => $project['result'],
				'permissions' => $permissions['results'],
				'project_id' => $project_id
				);

			$footer['javascript'] = '$(document).ready(function() {
				$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
				
				$(window).keydown(function(event){
					if(event.keyCode == 13) {
						event.preventDefault();
						return false;
					}
				});
				 $("#research_interests").select2({
                    tags:[],
                    tokenSeparators: [","],
                    minimumInputLength: 2
                });
                
            	$(".removeMemberButton").click(function()
				{
				    $(this).parent().parent().remove();
				});
                
                var new_member_id = ' . $num_project_members . ';
                
            	$("#addMember").click(function()
				{
					new_member_id ++;
					$("#members_table").append(\'<tr id="member_row_\' + new_member_id + \'"><td><input type="text" name="members[\' + new_member_id + \'][id]" id="new_member_select_\' + new_member_id + \'"></td><td><select name="members[\' + new_member_id + \'][permission]"><option value="1">Member</option><option value="2">Administrator</option></td><td><input type="text" name="members[\' + new_member_id + \'][role]" value="Contributor"></td><td><a class="btn btn-danger btn-small removeMemberButton"><i class = "icon-remove icon-white"></i>&nbsp;Remove</td></tr>\');
				
            	$(".removeMemberButton").click(function()
				{
				    $(this).parent().parent().remove();
				});
				
	                 $("#new_member_select_" + new_member_id).select2({
						placeholder: "Search for a staff member",
						minimumInputLength: 3,
						ajax: {
						    url: "' . $_SERVER['NUCLEUS_BASE_URI'] . 'typeahead/staff",
						    dataType: \'jsonp\',
						    quietMillis: 100,
						    
			                data: function (term, page) { // page is the one-based page number tracked by Select2
			                    return {
			                        q: term //search term
			                    };
			                },
			                results: function (data, page) {
			                    var more = (page * 10) < data.total; // whether or not there are more results available
			 
			                    // notice we return the value of more so Select2 knows if more results can be loaded
			                    return {results: data};
			                }					
			            }
			        });					
				});
			});';
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			$this->form_validation->set_rules('project_visibility', 'Project visibility', 'required');
	
			if ($this->form_validation->run())
			{	
				$fields['id'] = (int) $project_id;
				if($this->input->post('project_type'))
				{
					$fields['title'] = $this->input->post('project_title');
				}
				if ($this->input->post('project_description'))
				{
					$fields['summary'] = $this->input->post('project_description');
				}
				if ($this->input->post('research_interests'))
				{
					$fields['research_interests'] = $this->input->post('research_interests');
				}
				if($this->input->post('project_start_date'))
				{
					$fields['start_date'] = $this->input->post('project_start_date');
				}
				
				if($this->input->post('project_end_date'))
				{
					$fields['end_date'] = $this->input->post('project_end_date');
				}
				else
				{
					$fields['end_date'] = NULL;
				}
				if($this->input->post('project_visibility') === 'visible')
				{
					$fields['project_visibility'] = 1;
				}
				else
				{
					$fields['project_visibility'] = 0;
				}
				if($this->input->post('project_website'))
				{
					$fields['website'] = $this->input->post('project_website');
				}
				
				//Members
				$members = array();
				$members_test = array();
				
				if($this->input->post('members'))
				{
					$is_admin = FALSE;
					foreach($this->input->post('members') as $member)
					{
						if ($member['id'] !== '')
						{
							if ( ! in_array($member['id'], $members_test))
							{
								if((int)$member['permission'] === 2)
								{
									$is_admin = TRUE;
								}
								$members[] = array('person_id' => (int) $member['id'], 'permission_id' => (int) $member['permission'], 'role' => $member['role']);
							}
							$members_test[] = $member['id'];
						}
					}
					
					$fields['project_members'] = $members;
					
				}
				if($this->input->post('members') AND $is_admin === FALSE)
				{
					$this->session->set_flashdata('message', 'A Project administrator is required');
					$this->session->set_flashdata('message_type', 'error');
					
					redirect('project/' . $project_id . '/edit');
				}
									
				//POST to N2
				try
				{
					$curl_response = $this->n2->EditResearchProject($this->session->userdata('access_token'), $fields);
				}
				catch(Exception $e)
				{
					$this->session->set_flashdata('message', $e->getMessage());
					$this->session->set_flashdata('message_type', 'error');
					
					redirect('projects');
				}
				if ($curl_response['error'])
				{
					$header['flashmessage'] = $curl_response->error_message;
					$header['flashmessagetype'] = 'error';
									
					$this->load->view('inc/head', $header);
					$this->load->view('projects/edit', $data);
					$this->load->view('inc/foot', $footer);
				}
				else
				{
					$this->session->set_flashdata('message', 'Project updated!');
					$this->session->set_flashdata('message_type', 'success');
					
					redirect('projects');
				}
			}
			else
			{
				$this->load->view('inc/head', $header);
				$this->load->view('projects/edit', $data);
				$this->load->view('inc/foot', $footer);
			}
		}		
	}
	
	public function delete($project_id)
	{	
		
		$this->load->helper('form');
		$this->load->library('form_validation');
				
		try
		{
			$project = $this->n2->GetResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id));
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'Unable get project details');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');
		}	
		        
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		if ($project['result']['current_user_permission'] !== 'Administrator')
        {
			$this->load->view('inc/head', $header);
			$this->load->view('projects/unauthorised');
			$this->load->view('inc/foot');
        }
        else
        {
			$data = array(
				'project' => $project['result'],
				'project_id' => $project_id
				);
				
	
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			$this->form_validation->set_rules('project_title', 'Project Title', 'callback_project_title_check[' . $project['result']['title'] . ']');
			$this->form_validation->set_message('project_title_check', 'You did not type the correct project title');
	
			if ($this->form_validation->run())
			{			
				//DELETE to N2
				
				try
				{
					$project = $this->n2->DeleteResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id));
					$this->session->set_flashdata('message', 'Project deleted');
					$this->session->set_flashdata('message_type', 'success');
					
					redirect('projects');
				}
				catch(Exception $e)
				{		

					$this->session->set_flashdata('message', 'Unable to delete project');
					$this->session->set_flashdata('message_type', 'error');
					
					redirect('projects');
									
					$this->load->view('inc/head', $header);
					$this->load->view('projects/delete', $data);
					$this->load->view('inc/foot');
				}	
			}
			else
			{
				$this->load->view('inc/head', $header);
				$this->load->view('projects/delete', $data);
				$this->load->view('inc/foot');
			}
		}
	}
	
	public function archive($project_id)
	{
		try
		{
			$project = $this->n2->EditResearchProject($this->session->userdata('access_token'), array("id" => (int) $project_id, "research_project_status_id" => 19));
			$this->session->set_flashdata('message', 'Project archived');
			$this->session->set_flashdata('message_type', 'success');
			
			redirect('projects');
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'Unable to archive project');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');
		}
	}

	private function project_title_check($str, $project_title)
	{
		if ($str === $project_title)
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