<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function signin()
	{
		$this->load->library('oauth/libraries/oauth2');
		
		$provider = $this->oauth2->provider('unilincoln', array(
            'id' => 'gpkZ902wxY1D5b2EX8F1n0F9i9J33sX9',
            'secret' => '7E4v25QL2jGIXz97M40rzmN633NAP2V1'
        ));
        
        if ( ! $this->input->get('code'))
        {
            // Go auth!
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Assign user's data to session
                $this->session->set_userdata('access_token', $token->access_token);
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('user_name', $user->name);
                $this->session->set_userdata('user_sam', $user->sam);
                
                redirect('me');
            }

            catch (OAuth2_Exception $e)
            {
                show_error('Something unexpected happened when you were signing in, and we couldn\'t complete the process. Sorry about that.');
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