<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datasets extends CI_Controller {
	
	public function deposit_to_eprints($dataset_id)
	{
		if (!$this->session->userdata('access_token'))
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
		
		if ($dataset['result']['research_project']['current_user_role'] !== 'Administrator')
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
					$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
					
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
	            })';            
	            
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				$this->form_validation->set_rules('dataset_title', 'Dataset Title', 'required');
		
				if ($this->form_validation->run())
				{
					$dataset_metadata->set_title($this->input->post('dataset_title'));
					$dataset_metadata->set_uri_slug($this->input->post('dataset_uri_slug'));
					$dataset_metadata->set_creator($this->input->post('dataset_creators'));
					$dataset_metadata->set_date($this->input->post('dataset_date'));
					$dataset_metadata->set_metadata_visibility($this->input->post('dataset_metadata_visibility'));
					$dataset_metadata->set_is_published($this->input->post('dataset_is_published'));
					/*
					$this->load->library('../bridge_applications/sword');
					if($this->sword->create_dataset($_SERVER['SWORD_USER'], $_SERVER['SWORD_PASS'], $dataset_metadata))
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
*/
					$this->session->set_flashdata('message', 'This feature is not yet implemented');
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