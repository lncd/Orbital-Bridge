<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datasets extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		if (!$this->session->userdata('access_token'))
		{
			redirect('signin?destination=' . urlencode(current_url()));
		}
		
	}
	
	public function deposit_to_eprints($dataset_id)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		try
		{
			$dataset = $this->n2->GetDataset($this->session->userdata('access_token'), array("id" => (int) $dataset_id));
		}
		catch(Exception $e)
		{
			$this->session->set_flashdata('message', 'That dataset could not be found');
			$this->session->set_flashdata('message_type', 'error');
			redirect('projects');
		}
		
		$header = array(
			'page' => 'projects',
			'categories' => $this->bridge->categories(),
			'category_pages' => $this->bridge->category_pages()
		);
		
		$admin = FALSE;
		
		if ($dataset['result']['research_project']['current_user_permission'] !== 'Administrator')
        {
			$this->load->view('inc/head', $header);
			$this->load->view('projects/unauthorised');
			$this->load->view('inc/foot');
        }
		else
		{
			$this->load->library('../bridge_applications/ckan');
			if ($dataset_metadata = $this->ckan->read_dataset('https://ckan.lincoln.ac.uk/api/rest/dataset/' . $dataset['result']['ckan_id']))
			{
				$data = array(
					'dataset_metadata' => $dataset_metadata,
					'dataset' => $dataset['result']
				);
				
				$footer['javascript'] = '$(document).ready(function() {
					
					$(window).keydown(function(event){
						if(event.keyCode == 13) {
							event.preventDefault();
							return false;
						}
					});
					 $("#dataset_keywords").select2({
		                tags:[],
		                tokenSeparators: [","],
		                minimumInputLength: 2
		            });
					$("#dataset_subjects").select2({
						placeholder: "Search for a subject",
						minimumInputLength: 3,
						multiple: true,
						ajax: {
						    url: "' . $_SERVER['NUCLEUS_BASE_URI'] . 'typeahead/jacs_codes",
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
					$("#dataset_divisions").select2({
						placeholder: "Search for a Division",
						minimumInputLength: 3,
						multiple: true,
						ajax: {
						    url: "' . $_SERVER['NUCLEUS_BASE_URI'] . 'typeahead/departments",
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
	            })';
	            
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				$this->form_validation->set_rules('dataset_title', 'Title', 'required');
				$this->form_validation->set_rules('dataset_abstract', 'Abstract', 'required');
				$this->form_validation->set_rules('dataset_type_of_data', 'Type of Data', 'required');
				$this->form_validation->set_rules('dataset_keywords', 'Keywords', 'required');
				$this->form_validation->set_rules('dataset_subjects', 'Subjects', 'required');
				$this->form_validation->set_rules('dataset_divisions', 'Divisions', 'required');
				$this->form_validation->set_rules('dataset_metadata_visibility', 'Visibility', 'required');
		
				if ($this->form_validation->run())
				{
					try
					{
						$dataset_metadata->set_is_published('pub');
						$dataset_metadata->set_title($this->input->post('dataset_title'));
						$dataset_metadata->set_uri_slug($this->input->post('dataset_uri_slug'));
						$dataset_metadata->set_date(date('Y-m-d'));
						$dataset_metadata->set_publication_date(date('Y-m-d'));
						$dataset_metadata->set_publisher('University of Lincoln');
						$dataset_metadata->set_type_of_data($this->input->post('dataset_type_of_data'));
						$dataset_metadata->set_metadata_visibility($this->input->post('dataset_metadata_visibility'));
						$dataset_metadata->set_abstract($this->input->post('dataset_abstract'));
						$dataset_metadata->unset_keywords();
						foreach (explode(',', $this->input->post('dataset_keywords')) as $keyword)
						{
							$dataset_metadata->add_keyword($keyword);
						}
						$dataset_metadata->unset_subjects();
						foreach (explode(',', $this->input->post('dataset_subjects')) as $subject)
						{
							$dataset_metadata->add_subject($subject);
						}
						$dataset_metadata->unset_divisions();
						foreach (explode(',', $this->input->post('dataset_divisions')) as $division)
						{
							$dataset_metadata->add_division($division);
						}
						$dataset_metadata->unset_creators();
						foreach ($this->input->post('members') as $member)
						{
							$dataset_metadata->add_creator($member['name'], $member['permission'], $member['id']);
						}
						$dataset_metadata->set_research_project($dataset['result']['research_project']['id']);
					}
					catch (Exception $e)
					{
						$this->session->set_flashdata('message', 'There was an error in the project metadata. Dataset not deposited.');
						$this->session->set_flashdata('message_type', 'error');
					
						redirect('project/' . $dataset['result']['research_project']['id']);
					}
					
					// >> GET DOI HERE << //					
					try
					{
						$dataset_metadata->mint_doi();
					}
					catch (Exception $e)
					{
						$this->session->set_flashdata('message', 'Could not get DOI. Dataset not deposited');
						$this->session->set_flashdata('message_type', 'error');
					
						redirect('project/' . $dataset['result']['research_project']['id']);
					}

					try
					{
						$this->load->library('../bridge_applications/sword');
						
						if($eprint_metadata = $this->sword->create_dataset($dataset_metadata))
						{
							try
							{
								preg_match('/\/eprint\/([0-9]*)/', $eprint_metadata->sac_id, $eprint_id);
															
								$fields['eprints_id'] = $eprint_id[1];
								$fields['title'] = $dataset_metadata->get_title();
								$fields['doi'] = $dataset_metadata->get_doi();
								$fields['abstract'] = $dataset_metadata->get_abstract();
								$fields['date_year'] = (int) date('Y', strtotime($dataset_metadata->get_date()));
								$fields['publisher'] = $dataset_metadata->get_publisher();								
								
								$fields['eprints_type']['id'] = 8;
								$fields['dataset_id'] = $dataset_id;
								
								$fields['research_project']['id'] = $dataset_metadata->get_research_project();
											
								//POST to N2
					
								try
								{
									$curl_response = $this->n2->CreateEprint($this->session->userdata('access_token'), $fields);
									
									$this->session->set_flashdata('message', 'Dataset deposited to Lincoln repository');
									$this->session->set_flashdata('message_type', 'success');
									
									redirect('projects');
								}
								catch(Exception $e)
								{
									$this->session->set_flashdata('message', $e->getMessage());
									$this->session->set_flashdata('message_type', 'error');
																	
									redirect('project/' . $dataset['result']['research_project']['id']);
								}							
							}
							catch(Exception $e)
							{
								$this->session->set_flashdata('message', 'Dataset deposited, but was not recorded in the database');
								$this->session->set_flashdata('message_type', 'warning');
							
								redirect('project/' . $dataset['result']['research_project']['id']);
							}
						}
						else
						{	
							$this->session->set_flashdata('message', 'Unable to deposit Dataset');
							$this->session->set_flashdata('message_type', 'error');
						
							redirect('project/' . $dataset['result']['research_project']['id']);
						}
					}
					catch (Exception $e)
					{
						$this->session->set_flashdata('message', 'There was an error in the deposit process: ' . $e->getMessage());
						$this->session->set_flashdata('message_type', 'error');
					
						redirect('project/' . $dataset['result']['research_project']['id']);
					}

					$this->session->set_flashdata('message', 'Your dataset would have been deposited with the DOI of ' . $dataset_metadata->get_doi() . ', but the repository is unavailable right now.');
					$this->session->set_flashdata('message_type', 'info');
					
					redirect('project/' . $dataset['result']['research_project']['id']);
				}
				else
				{
					$this->load->view('inc/head', $header);
					$this->load->view('projects/deposit_dataset', $data);
					$this->load->view('inc/foot', $footer);
				}
			}
			else
			{
				$this->session->set_flashdata('message', 'Unable to get dataset information');
				$this->session->set_flashdata('message_type', 'error');
			
				redirect('project/' . $dataset['result']['research_project']['id']);
			}
		}
	}
}

// EOF