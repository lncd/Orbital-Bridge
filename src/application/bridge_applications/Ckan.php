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

class Ckan {
	
	public $configuration = '{
	"name": "CKAN",
	"multi_instance": false,
	"config_keys": [],
	"functions": [
	    {
	        "create_dataset": {
	            "name": "CreateDataset",
	            "description": "Creates a new dataset",
	            "accepts": [
	                {
	                    "name": "dataset",
	                    "description": "dataset object used to create a new dataset in CKAN",
	                    "type": "dataset"
	                }
	            ],
	            "returns": []
	        },
	        "read_dataset": {
	            "name": "ReadDataset",
	            "description": "Reads a dataset",
	            "accepts": [
	                {
	                    "name": "dataset_uri",
	                    "description": "URI of dataset to read",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "dataset",
	                    "description": "dataset object created from a dataset in CKAN",
	                    "type": "dataset"
	                }
	            ]
	        },
	        "read_datasets": {
	            "name": "ReadsDatasets",
	            "description": "Reads all datasets",
	            "accepts": [],
	            "returns": [
	                {
	                    "name": "datasets",
	                    "description": "array of dataset objects created from datasets in CKAN",
	                    "type": "array"
	                }
	            ]
	        },
	        "delete_dataset": {
	            "name": "DeleteDataset",
	            "description": "Deletes a dataset",
	            "accepts": [
	                {
	                    "name": "$dataset",
	                    "description": "ID of dataset to delete",
	                    "type": "dataset"
	                }
	            ],
	            "returns": []
	        },
	        "update_permissions": {
	            "name": "updatePermissions",
	            "description": "Updates a users permissions to a dataset",
	            "accepts": [
	                {
	                    "name": "user",
	                    "description": "user identifier",
	                    "type": "text"
	                },
	                {
	                    "name": "dataset",
	                    "description": "dataset user belongs to",
	                    "type": "text"
	                },
	                {
	                    "name": "role",
	                    "description": "new role for user",
	                    "type": "text"
	                }
	            ],
	            "returns": []
	        },
	        "create_group": {
	            "name": "CreateGroup",
	            "description": "Creates a group",
	            "accepts": [
	                {
	                    "name": "$group",
	                    "description": "name of new group",
	                    "type": "text"
	                }
	            ],
	            "config_keys": []
	        },
	        "read_group": {
	            "name": "ReadGroup",
	            "description": "Reads a group",
	            "accepts": [
	                {
	                    "name": "$group",
	                    "description": "name of group to read",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$group",
	                    "description": "group object read from the group in CKAN",
	                    "type": "object"
	                }
	            ]
	        },
	        "update_group": {
	            "name": "UpdateGroup",
	            "description": "Updates a group",
	            "accepts": [
	                {
	                    "name": "$group",
	                    "description": "name of group to update",
	                    "type": "text"
	                }
	            ],
	            "returns": []
	        },
	        "delete_group": {
	            "name": "DeleteGroup",
	            "description": "Deletes a group",
	            "accepts": [
	                {
	                    "name": "$group",
	                    "description": "ID of group to delete",
	                    "type": "text"
	                }
	            ],
	            "returns": []
	        },
	        "read_user": {
	            "name": "ReadUser",
	            "description": "Reads a user",
	            "accepts": [
	                {
	                    "name": "$user",
	                    "description": "ID of user to read",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$user",
	                    "description": "user object",
	                    "type": "object"
	                }
	            ]
	        },
	        "read_user_datasets": {
	            "name": "Read users datasets",
	            "description": "Reads a users datasets",
	            "accepts": [
	                {
	                    "name": "$user",
	                    "description": "ID of user to read datasets from",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$datasets",
	                    "description": "array of the users datasets",
	                    "type": "array"
	                }
	            ]
	        },
	        "read_user_datasets_rss": {
	            "name": "Read users datasets as RSS",
	            "description": "Reads a users datasets as RSS",
	            "accepts": [
	                {
	                    "name": "$user",
	                    "description": "ID of user to read datasets from in RSS format",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$rssfeed",
	                    "description": "datasets in RSS format",
	                    "type": "text"
	                }
	            ]
	        },
	        "read_user_activity": {
	            "name": "Read users activity",
	            "description": "Reads a users activity",
	            "accepts": [
	                {
	                    "name": "$user",
	                    "description": "ID of user to read activity from",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$activity",
	                    "description": "array of the users activity",
	                    "type": "array"
	                }
	            ]
	        },
	        "read_user_activity_rss": {
	            "name": "Read users activity as RSS",
	            "description": "Reads a users activity as RSS",
	            "accepts": [
	                {
	                    "name": "$user",
	                    "description": "ID of user to read activity from in RSS format",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$rssfeed",
	                    "description": "activity in RSS format",
	                    "type": "text"
	                }
	            ]
	        },
	        "datastore_query_to_csv": {
	            "name": "Convert datastore query result to CSV format",
	            "description": "Converts datastore query result to CSV format",
	            "accepts": [
	                {
	                    "name": "$url",
	                    "description": "URL of datastore query",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "",
	                    "description": "CSV formatted datastore query result",
	                    "type": "text"
	                }
	            ]
	        }
	    }
	]
}';
	
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

		$this->_ci->load->model('objects/Dataset_Object');
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

	public function read_datasets()
	{
		$fields = '{
			"limit": 100
		}';

		$datasets_data = json_decode($this->post_curl_request('https://ckan.lincoln.ac.uk/api/action/current_package_list_with_resources', $fields));

		$datasets = array();

		//Build bridge-object
		foreach ($datasets_data->result as $data)
		{
			$this->_ci->load->model('objects/Dataset_Object');
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
	 * Delete dataset
	 *
	 * string $dataset Dataset that will be deleted
	 *
	 * @return null
	 */

	public function delete_dataset($dataset)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/package_delete';

		$fields = array(
			'id' => $dataset
		);

		$fields = json_encode($fields);

		$this->post_curl_request($url, $fields);
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

		return $this->post_curl_request($url, $fields);
	}

	/**
	 * Reads Group
	 *
	 * string $group URI of group to read
	 *
	 * @return $dataset
	 */

	public function read_group($group)
	{
		$url = 'https://ckan.lincoln.ac.uk/api/action/group_show';

		$fields = array(
			'id' => $group
		);

		$fields = json_encode($fields);

		return $this->post_curl_request($url, $fields);
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
	 * Delete group
	 *
	 * string $group Group that will be deleted
	 *
	 * @return null
	 */

	public function delete_group($group)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/group_delete';

		$fields = array(
			'id' => $group
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
	 * Read Users Datasets
	 *
	 * string $user User to read
	 *
	 * @return null
	 */

	public function read_user_datasets($user)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_show';

		$fields = array(
			'id' => $user
		);

		$fields = json_encode($fields);

		$datasets = json_decode($this->post_curl_request($url, $fields));
		
		return $datasets->result->datasets;
	}

	/**
	 * Read Users Datasets as RSS
	 *
	 * string $user User to read
	 *
	 * @return null
	 */

	public function read_user_datasets_rss($user)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_show';

		$fields = array(
			'id' => $user
		);

		$fields = json_encode($fields);

		$datasets = json_decode($this->post_curl_request($url, $fields))->result->datasets;
		
	    header("Content-Type: application/rss+xml; charset=ISO-8859-1");
	    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	    $rssfeed .= '<rss version="2.0">';
	    $rssfeed .= '<channel>';
	    $rssfeed .= '<title>RSS feed of users\' datasets</title>';
	    $rssfeed .= '<link>https://orbital.lincoln.ac.uk/</link>';
	    $rssfeed .= '<description>Users datasets RSS feed</description>';
	    $rssfeed .= '<language>en-us</language>';
	    //$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';
		
		foreach ($datasets as $dataset)
		{
			$rssfeed .= '<item>';
			$rssfeed .= '<title>' . $dataset->title . '</title>';
			$rssfeed .= '<link>https://ckan.lincoln.ac.uk/dataset/' . $dataset->name . '</link>';
			$rssfeed .= '<description>' . $dataset->notes . '</description>';
			$rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($dataset->metadata_created)) . '</pubDate>';
			$rssfeed .= '<guid>https://ckan.lincoln.ac.uk/dataset/' . $dataset->name . '</guid>';
			$rssfeed .= '</item>';
		}
	 
	    $rssfeed .= '</channel>';
	    $rssfeed .= '</rss>';
	 
	    return $rssfeed;
	}

	/**
	 * Read Users Activity
	 *
	 * string $user User to read
	 *
	 * @return null
	 */

	public function read_user_activity($user)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_show';

		$fields = array(
			'id' => $user
		);

		$fields = json_encode($fields);

		$datasets = json_decode($this->post_curl_request($url, $fields));
		
		return $datasets->result->activity;
	}
	
	/**
	 * Read Users Activity as RSS
	 *
	 * string $user User to read
	 *
	 * @return null
	 */
	 
	 //**UNFINISHED**//

	public function read_user_activity_rss($user)
	{
		//set POST variables
		$url = 'https://ckan.lincoln.ac.uk/api/action/user_show';

		$fields = array(
			'id' => $user
		);

		$fields = json_encode($fields);

		$datasets = json_decode($this->post_curl_request($url, $fields))->result->activity;
		
	    header("Content-Type: application/rss+xml; charset=ISO-8859-1");
	    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	    $rssfeed .= '<rss version="2.0">';
	    $rssfeed .= '<channel>';
	    $rssfeed .= '<title>RSS feed of users\' datasets</title>';
	    $rssfeed .= '<link>https://orbital.lincoln.ac.uk/</link>';
	    $rssfeed .= '<description>Users datasets RSS feed</description>';
	    $rssfeed .= '<language>en-us</language>';
	    //$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';
		
		foreach ($datasets as $dataset)
		{
			if ( ! isset($dataset->groups))
			{
				$name = $dataset->groups[0];
			}
			else
			{
				$name = '#';
			}
			$rssfeed .= '<item>';
			$rssfeed .= '<title>' . $dataset->message . '</title>';
			$rssfeed .= '<link>https://ckan.lincoln.ac.uk/dataset/' . $name . '</link>';
			//$rssfeed .= '<description>' . $dataset->notes . '</description>'; //This should be added
			$rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($name)) . '</pubDate>';
			//$rssfeed .= '<guid>https://ckan.lincoln.ac.uk/dataset/' . $dataset->groups[0] . '</guid>'; //This should be added
			$rssfeed .= '</item>';
		}
	 
	    $rssfeed .= '</channel>';
	    $rssfeed .= '</rss>';
	 
	    return $rssfeed;
	}

	/**
	 * Parse datastore JSON to CSV
	 *
	 * string $url Query string to read
	 *
	 * @return array $output
	 */

	public function datastore_query_to_csv($url)
	{
		//$url is HTTPS. Make sure URL you paste has https, not http.
		$unprocessed = json_decode($this->get_curl_request($url))->hits->hits;
		$input_array = null;

		//Make $unrocessed into an array
		foreach ($unprocessed as $item)
		{
			$new_output = array();
			$new_output['id'] = $item->_id;

			foreach($item->_source as $key => $value)
			{
				$new_output[$key] = $value;
			}

			$input_array[] = $new_output;
			unset($new_output);
		}

		//Add keys to output csv string
		$keys = '';
		foreach($input_array[0] as $key => $value)
		{
			$keys .= $key . ',';
		}
		$keys .= "\r\n";

		//Implode array (Make into array of comma delimited rows)
		foreach($input_array as $row)
		{
			$output_array[] = implode($row, ',');
		}

		//Implode array again (Make comma delimited rows into CSV) and add all fields to output csv string
		return $keys . implode($output_array, "\r\n");
	}
}