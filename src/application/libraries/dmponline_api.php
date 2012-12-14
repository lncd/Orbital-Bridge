<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * DMPOnline Library
 *
 * Manages interfacing with DMPOnline.
 *
 * @category    Controller
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 */

class Dmponline_api {
	
	/**
	 * Post CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url     URL to POST CURL request
	 * array  $fields  Fields send over CURL
	 *
	 * @return null
	 * @access public
	 */

	public function post_curl_request($url, $fields, $api_key = NULL)
	{
		$post_body = array();
		foreach ($fields as $field => $value)
		{
			$post_body[] = $field . '=' . urlencode($value);
		}

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($post_body));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $post_body));
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		if ($api_key !== NULL)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'api_key: ' . $api_key));
		}
		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}

	/**
	 * Delete CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url     URL to DELETE CURL request
	 * array  $fields  Fields send over CURL
	 *
	 * @return null
	 * @access public
	 */

	public function delete_curl_request($url, $fields, $api_key = NULL)
	{
		$post_body = array();
		foreach ($fields as $field => $value)
		{
			$post_body[] = $field . '=' . urlencode($value);
		}

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($post_body));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $post_body));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		if ($api_key !== NULL)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'api_key: ' . $api_key));
		}
		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}

	/**
	 * Get CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url URL to GET CURL request
	 *
	 * @return null
	 * @access public
	 */

	public function get_curl_request($url, $api_key)
	{
		//open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'api_key: ' . $api_key));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}

	/**
	 * Request API key
	 *
	 * Log in to the system; get a new api_key
	 *
	 * string $email    The users email
	 * string $password The users password
	 *
	 * @return $api_key
	 * @access public
	 */

	public function request_api_key($email, $password)
	{		
		$fields = array(
			'email' => $email,
			'password' => $password
		);

		return $this->post_curl_request('https://dmponline.dcc.ac.uk/api/v1/authenticate', $fields);
	}

	/**
	 * Revoke API key
	 *
	 * Log out; expire the supplied api_key
	 *
	 * string $api_key The api key to expire
	 *
	 * @return BOOL
	 * @access public
	 */

	public function revoke_api_key($api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->delete_curl_request('https://dmponline.dcc.ac.uk/api/v1/authenticate', $fields);
	}

	/**
	 * Get templates
	 *
	 * Get list of template editions available to the current api_key with their associated {editionKey} identifiers
	 *
	 * string $api_key The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_templates($api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates', $fields);
	}

	/**
	 * Get template questions
	 *
	 * Get default list of questions, including {questionKey} that make up the template edition
	 *
	 * string $editionKey The template edition
	 * string $api_key    The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_template_questions($editionKey, $api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates/' . $editionKey, $fields);
	}

	/**
	 * Get template users
	 *
	 * Get list of users that have used the template in a plan
	 *
	 * string $api_key The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_template_users($editionKey, $api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates/' . $editionKey . '/users', $fields);
	}

	/**
	 * Get template edition instances
	 *
	 * Get a list of template edition instances (phases in user plans)
	 *
	 * string $editionKey The template edition
	 * string $api_key The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_specific_template_instances($editionKey, $api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates/' . $editionKey . '/instances', $fields);
	}

	/**
	 * Get template edition instances
	 *
	 * Get all questions and answers entered for the template edition instance
	 *
	 * string $editionKey The template edition
	 * string $editionKey The instance
	 * string $api_key    The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_template_instance_questions_answers($editionKey, $instanceKey, $api_key)
	{		
		$fields = array(
			'api_key' => $api_key
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates/' . $editionKey . '/instance/' . $instanceKey, $fields);
	}

	/**
	 * Get answers to question in template edition
	 *
	 * Retrieve all answers for a specific question, including associated information such as user reference and last updated date
	 *
	 * string $editionKey The template edition
	 * string $editionKey The instance
	 * string $api_key    The api key to expire
	 *
	 * @return array
	 * @access public
	 */

	public function get_specific_template_answers($editionKey, $questionKey, $api_key)
	{		
		$fields = array(
			'api_key' => $api_key,
			'questionKey' => $questionKey
		);

		return $this->get_curl_request('https://dmponline.dcc.ac.uk/api/v1/templates/' . $editionKey . '/answers', $fields);
	}
}