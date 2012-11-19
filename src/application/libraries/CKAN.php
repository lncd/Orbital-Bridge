<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CKAN Library
 *
 * Manages interfacing with CKAN.
 *
 * @category    Library
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
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
	 * @access public
	 */

	public function post_curl_request($url, $fields)
	{
		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		//curl_setopt($ch, CURLOPT_USERPWD, 'username' . ":" . 'password');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $_SERVER['CKAN_API_KEY']));

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

	public function get_curl_request($url)
	{
		//open connection
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $_SERVER['CKAN_API_KEY']));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		
		return $result;
	}

	/**
	 * Creates dataset
	 *
	 * object $dataset Dataset to create
	 *
	 * @return null
	 * @access public
	 */

	public function create_dataset($dataset)
	{
		//$dataset is a bridge dataset object. use another function to create a dataset object from a source, which this function can use.
	
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
	 * Reads Dataset
	 *
	 * string $dataset_uri URI of dataset to read
	 *
	 * @return $dataset The dataset is returned in array format
	 * @access public
	 */

	public function read_dataset($dataset_uri = 'https://ckan.lincoln.ac.uk/api/rest/dataset/')
	{
		$data = json_decode($this->get_curl_request($dataset_uri));

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
	 * Reads all Datasets
	 *
	 * string $uri URI of datasets API
	 *
	 * @return $datasets The datasets are returned in array format
	 * @access public
	 */

	//UNFINISHED//

	public function read_datasets($uri = 'https://ckan.lincoln.ac.uk/api/action/current_package_list_with_resources')
	{
		$fields = '{
			"limit": 100
		}';

		$datasets_data = json_decode($this->post_curl_request($uri, $fields));

		$datasets = array();

		//Build bridge-object
		foreach ($datasets_data->result as $data)
		{
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

			$datasets[] = $dataset;
		}
		return $datasets;
	}

	/**
	 * Update users dataset permissions
	 *
	 * string $user    User whose permissions will be updated
	 * string $dataset Dataset to changeusers permissions to
	 * array  $role    What permission to give the user
	 *
	 * @return null
	 * @access public
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
	 * Creates group
	 *
	 * object $group Group to create
	 *
	 * @return null
	 * @access public
	 */

	public function create_group($group)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/group_create';

		$fields = array(
			'name' => $group
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
	}

	/**
	 * Reads Group
	 *
	 * string $group URI of group to read
	 *
	 * @return $dataset
	 */

	 //UNFINISHED//

	public function read_group($group)
	{
		$url = 'https://ckan.lincoln.ac.uk/api/action/group_create';

		//CREATE GROUP

	}

	/**
	 * Update group
	 *
	 * string $group       Group that will be updated
	 * string $name        Name of the group
	 * string $title       Title of the group
	 * string $description Group description
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

		return $this->post_curl_request($url, $fields);
	}

	/**
	 * Parse datastore JSON to array
	 *
	 * string $url Query string to read
	 *
	 * @return array $output
	 */

	public function datastore_query_to_array($url)
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