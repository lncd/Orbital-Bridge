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
		
		$curl_response = $this->n2->get_curl_request('research_projects?account=' . $this->session->userdata('user_employee_id'), $this->session->userdata('access_token'));

		$projects_active = array();
		$projects_inactive = array();
		
		$total_funding = 0;
		
		if($curl_response !== FALSE)
		{
			$projects = json_decode($curl_response);
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
				
				if ($project->funding !== NULL AND $project->funding->currency->name === 'Sterling')
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
					minScale: "days",
					maxScale: "months"
				});
				';
			
			$this->load->view('inc/head', $header);
			$this->load->view('projects/my', $data);
			$this->load->view('inc/foot', $footer);
		}
		else
		{					
			$this->load->view('inc/head', $header);
			$this->load->view('projects/error_projects');
			$this->load->view('inc/foot');
		}
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
			
			$("#project_type").change(function () {
				if ($("#project_type").val() == "funded")
				{
					$(\'#funding_div\').show(200, "swing");
				}
				else if ($("#project_type").val() == "unfunded")
				{
					$(\'#funding_div\').hide(200, "swing");
				}
			})
		});';
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('project_title', 'Project Title', 'trim|required|max_length[255]|min_length[3]');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'trim|required');
		$this->form_validation->set_rules('project_type', 'Project Type', 'valid_match[funded, unfunded)');

		if ($this->form_validation->run())
		{

			$fields = '{
				"title" : "' . $this->input->post('project_title') . '",' .
				'"lead" : "' . $this->session->userdata('user_id') . '",' .
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
					$fields .= '0",	
					"currency_id" : null,' .
					'"funding_amount" : null,';
				}			
					
				$fields .=
				'"start_date" : "' . $this->input->post('project_start_date') . '",';
				
				if ($this->input->post('project_end_date'))
				{
					$fields .= '"end_date" : "' . $this->input->post('project_end_date') . '"';
				}
				else
				{
					$fields .= '"end_date" : null';
				}
				$fields .= '}';
				
			//POST to N2
			
			$curl_response = $this->n2->post_curl_request('research_projects', $fields, $this->session->userdata('access_token'));
			
			if($curl_response !== FALSE)
			{			
				$response = json_decode($curl_response);
				
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
					$this->session->set_flashdata('message', 'Project created');
					$this->session->set_flashdata('message_type', 'success');
					
					redirect('projects');
				}
			}
			else
			{
				$this->session->set_flashdata('message', 'Unable to create project');
				$this->session->set_flashdata('message_type', 'error');
				
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
		
		$curl_response = $this->n2->get_curl_request('research_projects/id/' . $project_id . '?access_token=' . $this->session->userdata('access_token'));

		if($curl_response !== FALSE)
		{		
			$projects = json_decode($curl_response);		
        
			$header = array(
				'page' => 'projects',
				'categories' => $this->bridge->categories(),
				'category_pages' => $this->bridge->category_pages()
			);
			
			$data = array(
				'project' => $projects->result
				);

			$this->load->view('inc/head', $header);
			$this->load->view('projects/project', $data);
			$this->load->view('inc/foot');
			
		}
		else
		{
			$this->session->set_flashdata('message', 'Unable to get project');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');
		}
	}

	public function edit($project_id)
	{
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		
		$curl_response = $this->n2->get_curl_request('research_projects/id/' . $project_id . '?access_token=' . $this->session->userdata('access_token'));
		
		if($curl_response !== FALSE)
		{		
			$projects = json_decode($curl_response);	
        
			$header = array(
				'page' => 'projects',
				'categories' => $this->bridge->categories(),
				'category_pages' => $this->bridge->category_pages()
			);
			
			if ($projects->result->project_lead->employee_id !== $this->session->userdata('user_employee_id'))
	        {
				$this->load->view('inc/head', $header);
				$this->load->view('projects/unauthorised');
				$this->load->view('inc/foot');
	        }
	        else
	        {
	        	$num_project_members = count($projects->result->research_project_members);
	        
	        	$tags = null;
	        
				$data = array(
					'project' => $projects->result,
					'project_id' => $project_id
					);
	
				$footer['javascript'] = '$(document).ready(function() {
					$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
					
					$("#project_type").change(function () {
						if ($("#project_type").val() == "funded")
						{
							$(\'#funding_div\').show(200, "swing");
						}
						else if ($("#project_type").val() == "unfunded")
						{
							$(\'#funding_div\').hide(200, "swing");
						}
					});
					
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
						$("#members_table").append(\'<tr id="member_row_\' + new_member_id + \'"><td><input type="text" name="members[\' + new_member_id + \'][id]" id="new_member_select_\' + new_member_id + \'"></td><td><select name="members[\' + new_member_id + \'][role]"><option value="1">Member</option></td><td><a class="btn btn-danger btn-small removeMemberButton"><i class = "icon-remove icon-white"></i> Remove</td></tr>\');
					
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
					
	                 $("#project_lead").select2({
						placeholder: "Enter project lead",
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
			            },
		                initSelection : function (element, callback) {
				        	callback({
					        	id:' . $projects->result->project_lead->id . ',
					        	text:"' . $projects->result->project_lead->first_name . ' ' . $projects->result->project_lead->last_name . '"
					        });
				        }
	
			        });
				});';
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				$this->form_validation->set_rules('project_title', 'Project Title', 'trim|required|max_length[255]|min_length[3]');
				$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'trim|required');
		
				if ($this->form_validation->run())
				{	
					$fields['title'] = $this->input->post('project_title');
					$fields['lead'] = $this->input->post('project_lead');
					$fields['description'] = $this->input->post('project_description');
					$fields['research_interests'] = $this->input->post('research_interests');
					
					if ($this->input->post('project_type') === 'funded')
					{
						$fields['funded'] = TRUE;
						$fields['currency_id'] = $this->input->post('project_funding_currency');
						$fields['funding_amount'] = $this->input->post('project_funding_amount');
					}
	
					else
					{
						$fields['funded'] = FALSE;
						$fields['currency_id'] = NULL;
						$fields['funding_amount'] = NULL;
					}
					
					$fields['start_date'] = $this->input->post('project_start_date');
					
					if($this->input->post('end_date'))
					{
						$fields['end_date'] = $this->input->post('end_start_date');
					}
					else
					{
						$fields['end_date'] = NULL;
					}
					
					//Members
					$members = array();
					$members_test = array();
					
					if($this->input->post('members'))
					{
						foreach($this->input->post('members') as $member)
						{
							if ($member['id'] !== '')
							{
								if ( ! in_array($member['id'], $members_test))
								{
									$members[] = array('person_id' => $member['id'], 'role_id' => $member['role']);
								}
								$members_test[] = $member['id'];
							}
						}
						
						$fields['project_members'] = $members;
					}
					
					$fields = json_encode($fields);
					
					//POST to N2
	
					$curl_response = $this->n2->post_curl_request('research_projects/id/' . $project_id, $fields, $this->session->userdata('access_token'));
	
					if ($curl_response !== FALSE)
					{
						$response = json_decode($curl_response);
					
						if ($response->error)
						{
							$header['flashmessage'] = $response->error_message;
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
						$this->session->set_flashdata('message', 'Unable to update project.');
						$this->session->set_flashdata('message_type', 'error');
						
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
		else
		{
			$this->session->set_flashdata('message', 'Unable to edit project');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');			
		}
	}
	
	public function delete($project_id)
	{
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin');
		}		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
				
		$curl_response = $this->n2->get_curl_request('research_projects/id/' . $project_id . '?access_token=' . $this->session->userdata('access_token'));
		
		if($curl_response !== FALSE)
		{		
			$projects = json_decode($curl_response);	
		        
			$header = array(
				'page' => 'projects',
				'categories' => $this->bridge->categories(),
				'category_pages' => $this->bridge->category_pages()
			);
			if ($projects->result->project_lead->employee_id !== $this->session->userdata('user_employee_id'))
	        {
				$this->load->view('inc/head', $header);
				$this->load->view('projects/unauthorised');
				$this->load->view('inc/foot');
	        }
	        else
	        {
				$data = array(
					'project' => $projects->result,
					'project_id' => $project_id
					);
					
		
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				$this->form_validation->set_rules('project_title', 'Project Title', 'callback_project_title_check[' . $projects->result->title . ']');
				$this->form_validation->set_message('project_title_check', 'You did not type the correct project title');
		
				if ($this->form_validation->run())
				{			
					//DELETE to N2
					
					$curl_response = $this->n2->delete_curl_request('research_projects/id/' . $project_id, $this->session->userdata('access_token'));
					
					if ($curl_response !== FALSE)
					{				
						$response = json_decode($curl_response);
						
						if ($response->error)
						{
							$header['flashmessage'] = $response->error_message;
							$header['flashmessagetype'] = 'error';
											
							$this->load->view('inc/head', $header);
							$this->load->view('projects/delete', $data);
							$this->load->view('inc/foot');
						}
						else
						{
							$this->session->set_flashdata('message', 'Project deleted');
							$this->session->set_flashdata('message_type', 'success');
							
							redirect('projects');
						}
					}
					else
					{
						$this->session->set_flashdata('message', 'Unable to delete project');
						$this->session->set_flashdata('message_type', 'error');
						
						redirect('projects');
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
		else
		{
			$this->session->set_flashdata('message', 'Unable to delete project');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('projects');
		}
	}
	

	public function project_title_check($str, $project_title)
	{
		if ($str == $project_title)
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