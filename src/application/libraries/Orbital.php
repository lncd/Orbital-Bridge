<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Orbital Core Library
 *
 * Manages interfacing with Orbital Core.
 *
 * @category   Library
 * @package    Orbital
 * @subpackage Manager
 * @autho      Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
 */

class Orbital {

	/**
	 * CodeIgniter Instance.
	 *
	 * @var $_ci 
	 */

	private $_ci;
	
	/**
	 * Constructor
	 */

	function __construct()
	{
		$this->_ci =& get_instance();
	}
	
	/**
	 * Builds the content common to every page
	 *
	 *@return ARRAY
	 */

	public function common_content()
	{

		$common_content = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->_ci->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->_ci->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->_ci->config->item('orbital_core_location')
		);

		if ($this->_ci->session->userdata('current_user_string'))
		{
			$common_content['user_presence'] = lang('navigation_signed_in') . '<a href="' . site_url('me') . '">' . $this->_ci->session->userdata('current_user_string') . '</a> &middot; <a href="' . site_url('signout') . '">' . lang('navigation_sign_out') . '</a>';
		}
		else
		{
			$common_content['user_presence'] = '<a href="' . site_url('signin') . '">' . lang('navigation_sign_in') . '</a>';
		}

		$common_content['nav_menu'] = array();

		if ($this->_ci->session->userdata('current_user_string'))
		{

			$common_content['nav_menu'][] = array (
				'name' => 'Your Projects',
				'uri' => site_url('projects')
			);

			$common_content['nav_menu'][] = array (
				'name' => 'Your Profile',
				'uri' => site_url('profile')
			);

			if ($this->_ci->session->userdata('system_admin'))
			{
				$common_content['nav_menu'][] = array (
					'name' => 'Administration',
					'uri' => site_url('admin')
				);
			}

		}

		$this->data = $common_content;
		return $common_content;

	}
}