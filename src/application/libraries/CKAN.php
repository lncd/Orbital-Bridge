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
	 * Post CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url     URL to POST CURL request
	 * array  $fields  Fields send over CURL
	 *
	 * @return null
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
	 * Get CURL Request
	 *
	 * Sends the CURL request, performing the request sent by another function
	 *
	 * string $url     URL to GET CURL request
	 *
	 * @return null
	 */

	public function get_curl_request($url)
	{
		//open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $_SERVER['CKAN_API_KEY']));

		//execute post
		return $result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}

	/**
	 * Creates dataset in CKAN
	 *
	 * string $dataset Dataset to create
	 *
	 * @return null
	 */

	public function create_dataset($dataset)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/rest/dataset';

		$fields = array(
			'title' => $dataset->get_title(),
			'name' => $dataset->get_uri_slug(),
			'author' => $dataset->get_author()
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
	}


	/**
	 * Update users dataset permissions
	 *
	 * string $user    User whose permissions will be updated
	 * string $dataset Dataset to changeusers permissions to
	 * array  $role    What permission to change to
	 *
	 * @return null
	 */

	public function update_permissions($user, $dataset, $role)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_role_update';

		$fields = array(
			'user' => $user,
			'domain_object' => $dataset,
			'roles' => $role //Must be in array of 1 object
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
	}

	/**
	 * Reads Dataset
	 *
	 * string $dataset_uri URI of dataset to read
	 *
	 * @return $dataset
	 */

	public function read_dataset($dataset_uri = 'https://ckan.lincoln.ac.uk/api/rest/dataset/')
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

	/**
	 * Reads Group
	 *
	 * string $group URI of dataset to read
	 *
	 * @return $dataset
	 */

	public function read_group($group = 'https://ckan.lincoln.ac.uk/api/rest/group/')
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $group);
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
		$dataset->set_creator($data->name);
		$dataset->set_subjects(array()); //JACS CODES
		$dataset->set_date(strtotime($data->created));
		foreach($data->tags as $tag)
		{
			$dataset->add_keyword($tag);
		}
		$dataset->set_uri_slug($group);

		return $dataset;
	}

	/**
	 * Update group
	 *
	 * string $group    Group that will be updated
	 * string $datasets Datasets it should contain
	 *
	 * @return null
	 */

	public function update_group($group, $name, $title, $description)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/group_update';

		$fields = array(
			'id' => $group,
			'name' => $name,
			'title' => $title,
			'description' => $description
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
	}

	/**
	 * Read User
	 *
	 * string $user User to read
	 *
	 * @return null
	 */

	public function read_user($user)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_show';

		$fields = array(
			'id' => $user
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
	}
	
	/**
	 * Parse datastore JSON to CSV
	 *
	 * string $url Query string to read
	 *
	 * @return null
	 */

	public function datastore_query_to_CSV($url)
	{
		$unprocessed = json_decode($this->get_curl_request($url))->hits->hits;
		$output = null;
		
		foreach ($unprocessed as $item)
		{
			$output['id'] = $item->_id;
			foreach($item->_source as $key => $value)
			{
				$output[$key] = $value;
			}
		}
		return $output;
	}
}