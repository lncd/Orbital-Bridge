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

		$dataset = $this->n2->GetDataset($this->session->userdata('access_token'), array("id" => (int) $dataset_id));
		
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
			$data = array(
				'dataset_metadata' => $this->ckan->read_dataset('https://ckan.lincoln.ac.uk/api/rest/dataset/' . $dataset['result']['ckan_id']),
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
				$this->session->set_flashdata('message', 'This feature has not yet been implemented');
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
	}
}

// EOF