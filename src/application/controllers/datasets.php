<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datasets extends CI_Controller {
	
	public function deposit_to_eprints($dataset_id)
	{
		if ( ! $this->session->userdata('access_token'))
		{
			redirect('signin');
		}
		
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
					'dataset_id' => $dataset_id
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
						placeholder: "Search for a JACS code",
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
	            })';
	            
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				$this->form_validation->set_rules('dataset_title', 'Dataset Title', 'required');
				$this->form_validation->set_rules('dataset_abstract', 'Dataset Abstract', 'required');
				$this->form_validation->set_rules('dataset_creator', 'Dataset Creator', 'required');
				$this->form_validation->set_rules('dataset_contributor', 'Dataset Contributor', 'required');
				$this->form_validation->set_rules('dataset_type_of_data', 'Dataset Data Type', 'required');
				$this->form_validation->set_rules('dataset_keywords', 'Dataset Keywords', 'required');
				$this->form_validation->set_rules('dataset_subjects', 'Dataset Subjects', 'required');
				$this->form_validation->set_rules('dataset_divisions', 'Dataset Divisions', 'required');
				$this->form_validation->set_rules('dataset_metadata_visibility', 'Dataset Visibility', 'required');
		
				if ($this->form_validation->run())
				{
					try
					{
						$dataset_metadata->set_is_published('pub');
						$dataset_metadata->set_title($this->input->post('dataset_title'));
						$dataset_metadata->set_uri_slug($this->input->post('dataset_uri_slug'));
						$dataset_metadata->unset_creators();
						foreach (explode(',', $this->input->post('dataset_creators')) as $creator)
						{
							$dataset_metadata->add_creator($creator, 'creator', NULL);
						}
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
							$dataset_metadata->add_subjects($subject);
						}
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
						
						if($this->sword->create_dataset($dataset_metadata))
						{
							$this->session->set_flashdata('message', 'Dataset deposited');
							$this->session->set_flashdata('message_type', 'info');
						
							redirect('project/' . $dataset['result']['research_project']['id']);
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
						$this->session->set_flashdata('message', 'There was an error in the deposit process. The metadata may be incorrectly formed for input to ePrints.');
						$this->session->set_flashdata('message_type', 'error');
					
						redirect('project/' . $dataset['result']['research_project']['id']);
					}

					$this->session->set_flashdata('message', 'An unknown error occured');
					$this->session->set_flashdata('message_type', 'error');
					
					redirect('projects');					
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