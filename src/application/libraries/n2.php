<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * N2 Library
 *
 * Manages interfacing with N2.
 *
 * @category    Controller
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 */

class N2 {
	
	/**
	 * Get CURL Request
	 *
	 * Get CURL request
	 *
	 * @return null
	 * @access public
	 */

	public function get_curl_request($url, $access_token = NULL)
	{
		//open connection
		$ch = curl_init();
		
		$headers = array(
		);
		if ($access_token !== NULL)
		{
			$headers[] = 'Authorization: Bearer ' . base64_encode($access_token);
		}

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $_SERVER['NUCLEUS_BASE_URI'] . $_SERVER['NUCLEUS_BASE_URI'] . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}	
	
	
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

	public function post_curl_request($url, $fields, $access_token = NULL)
	{
		//open connection
		$ch = curl_init();
		
		$headers = array(
			'Content-Type: application/json'
		);
		if ($access_token !== NULL)
		{
			$headers[] = 'Authorization: Bearer ' . base64_encode($access_token);
		}

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $_SERVER['NUCLEUS_BASE_URI'] . $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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
	 * string $url     URL
	 * array  $fields  Fields send over CURL
	 *
	 * @return null
	 * @access public
	 */

	public function delete_curl_request($url, $access_token = NULL)
	{		
		$headers = array();
		if ($access_token !== NULL)
		{
			$headers[] = 'Authorization: Bearer ' . base64_encode($access_token);
		}

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $_SERVER['NUCLEUS_BASE_URI'] . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		return $result;
	}	
}