<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function signin()
	{
		$this->load->library('oauth/libraries/oauth2');
		
		$provider = $this->oauth2->provider('unilincoln', array(
            'id' => $_SERVER['OAUTH_ID'],
            'secret' => $_SERVER['OAUTH_SECRET']
        ));
        
        if ( ! $this->input->get('code'))
        {
            $provider->authorize();
        }
        else
        {
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);
                
                // Assign user's data to session
                $this->session->set_userdata('access_token', $token->access_token);
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('user_name', $user->name);
                $this->session->set_userdata('user_sam', $user->sam);

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
                redirect();
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