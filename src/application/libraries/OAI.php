<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OAI-PMH Library
 *
 * Outputs list of datasets in OAI-LMH format.
 *
 * @category    Library
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 *
 * @todo Write library.
 */

class OAI {

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

	public function post_curl_request($url, $fields)
	{
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $_SERVER['CKAN_API_KEY']));

		//execute post
		$result = curl_exec($ch);
		
		//close connection
		curl_close($ch);
	}
	
	/**
	 * Displays OAI-PMH list of datasets
	 *
	 * @return $OAI 
	 * @access public
	 */

	public function display_OAI_PMH($uri = 'https://ckan.lincoln.ac.uk/api/action/current_package_list_with_resources')
	{
		$fields = array(
			'limit' => 30
		);
			
		$data = $this->post_curl_request($uri, $fields);
var_dump($data);
		//USE SIMPLEXML TO BUILD OUTPUT

		$this->_ci->load->model('Dataset_Object');
		$dataset = new Dataset_Object();

		$dataset->set_title($data->title);
		$dataset->set_uri_slug(url_title($data->title, '_', TRUE));
		$dataset->set_creator($data->author);
		$dataset->set_subjects(array()); //JACS CODES
		$dataset->set_date(strtotime($data->metadata_created));
		foreach($data->tags as $tag)
		{
			$dataset->add_keyword($tag);
		}
		$dataset->set_uri_slug($data->url);

		return $dataset;
	}
}