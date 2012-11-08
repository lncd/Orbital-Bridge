<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CKAN Library
 *
 * Manages interfacing with CKAN.
 *
 * @category   Library
 * @package    Orbital
 * @subpackage Manager
 * @autho      Harry Newton <hnewton@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
 */

class CKAN {

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
	 * Imports datsset from SWORD to CKAN
	 *
	 *@return ARRAY
	 */

	public function create_dataset($dataset, $API_key)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/rest/dataset';

		$fields = array(
			'title' => $dataset->get_title(),
			'name' => $dataset->get_uri_slug(),
			'author' => $dataset->get_author()
		);

		$fields = json_encode($fields);


		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $API_key));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}

	public function read($dataset_uri = 'https://ckan.lincoln.ac.uk/api/rest/dataset/')
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $dataset_uri);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($data);
		
		//Build bridge-object
		
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
	
	
	public function update_permissions($user, $dataset, $role, $API_key)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_role_update';//{"user": "dread", "domain_object": "freshwateratlasrivers", "roles": ["admin"]}' -H "Authorization:{your-api-key}"

		$fields = array(
			'user' => $user,
			'domain_object' => $dataset,
			'roles' => $role
		);

		$fields = json_encode($fields);


		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $API_key));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}
}