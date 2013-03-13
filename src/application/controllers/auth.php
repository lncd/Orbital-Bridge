<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function signin()
	{
		$this->load->library('oauth/libraries/oauth2');
		
		$provider = $this->oauth2->provider('unilincoln2', array(
            'id' => $_SERVER['OAUTH_ID'],
            'secret' => $_SERVER['OAUTH_SECRET']
        ));
        
        if ( ! $this->input->get('code'))
        {
        
        	$state = array(
        		'token' => uniqid()
        	);
        	
        	$this->session->set_userdata('sso_token', $state['token']);
        
        	if ($this->input->get('destination'))
        	{
	        	$state['destination'] = $this->input->get('destination');
        	}
        	
        	$provider->state = serialize($state);
        	
        	$provider->scope = array('user.basic', 'user.contact', 'user.research');
        	
            $provider->authorize();
        }
        else
        {
        
        	if ($this->input->get('state'))
        	{
	        	if ($state = unserialize($this->input->get('state')))
	        	{
		        	if ($state['token'] === $this->session->userdata('sso_token'))
		        	{
		        	
		        		try
			            {
			                $token = $provider->access($_GET['code']);
			
			                $user = $provider->get_user_info($token);
			                
			                // Assign user's data to session
			                $this->session->set_userdata('access_token', $token->access_token);
			                $this->session->set_userdata('user_id', $user->id);
			                $this->session->set_userdata('user_name', $user->name);
			                $this->session->set_userdata('user_sam_id', $user->sam_id);
			                $this->session->set_userdata('user_employee_id', $user->employee_id);
			
			                // Do some funky database testing to see if the user already exists
							$u = new User();
			                
			                $db_user = $u->where('auth_id', $user->id)->get();
			                
			                if ($db_user->result_count() === 1)
			                {
				                $this->session->set_userdata('user_admin', (bool) $db_user->admin);
			                }
			                else
			                {
				                // User doesn't exist. Save it up!
				                $u->auth_id = $user->id;
				                $u->save();
				                
				                $this->session->set_userdata('user_admin', FALSE);
				                
			                }
			                
			                if (isset($state['destination']))
			                {
				                redirect($state['destination']);
			                }
			                else
			                {
			                	redirect();
			                }
			            }
			
			            catch (OAuth2_Exception $e)
			            {
			                show_error('Something unexpected happened when you were signing in, and we couldn\'t complete the process. Sorry about that.');
			            }
			        	
		        	}
		        	else
		        	{
		        		show_error('The response from the sign-in service did not contain a valid security token.');
		        	}
	        	}
	        	else
	        	{
		        	show_error('We received an invalid response from the University\'s sign-in service, and are unable to complete signing you in.');
	        	}
        	}
        	else
        	{
	        	show_error('We received an unexpected or incomplete response from the University\'s sign-in service, and are unable to complete signing you in.');
        	}
        }
	}
	
	public function signout()
	{
		$this->session->sess_destroy();
		redirect('https://sso.lincoln.ac.uk/oauth/sign_out?redirect_uri=' . urlencode(site_url()));
	}
}

// EOF