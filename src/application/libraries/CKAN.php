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

	public function create_dataset()
	{
		//set POST variables
		$url = 'http://ckan.lncd.org/api/rest/dataset';
		
		$fields = array(
			'name' => 'test',
			'title' => 'Changed Test Dataset'
		);
		$fields = json_encode($fields);
		
		//open connection
		$ch = curl_init();
	
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_USERPWD, 'hnewton' . ":" . '');  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', 'Authorization: 62935967-73a5-474c-9ab3-22c849bbd1cd'));
	
		//execute post
		$result = curl_exec($ch);
	
		//close connection
		curl_close($ch);
	}
}