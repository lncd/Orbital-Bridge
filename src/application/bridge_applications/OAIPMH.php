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
 */

class OAIPMH {

	public $configuration = '{
	"name": "OAIPMH",
	"multi_instance": false,
	"config_keys": [],
	"functions": [
	    {
	        "read_OAI_PMH_group_datasets": {
	            "name": "Read OAI_PMH group datasets",
	            "description": "Read a groups datasets and output in OAI_PMH format ",
	            "accepts": [
	                {
	                    "name": "$group",
	                    "description": "Group to read datasets from",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$output",
	                    "description": "OAI formatted list of datasets",
	                    "type": "array"
	                }
	            ]
	        },
	        "convert_tabular_to_text": {
	            "name": "Convert tabular data to text",
	            "description": "Converts tabular data to text ",
	            "accepts": [
	            ],
	            "returns": [
	                {
	                    "name": "$output",
	                    "description": "OAI formatted list of datasets",
	                    "type": "array"
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
	 * Displays OAI-PMH list of a groups datasets
	 *
	 * @access public
	 */

	public function read_OAI_PMH_group_datasets($group)
	{
		$fields = '{
			"limit": 100,
			"id" : ' . $group . '
		}';

		return $this->display_OAI_PMH('https://ckan.lincoln.ac.uk/api/action/group_package_show', $fields);
	}

	/**
	 * Displays OAI-PMH list of all datasets
	 *
	 * @access public
	 */

	public function read_OAI_PMH_all_datasets()
	{
		$fields = '{
			"limit": 100
		}';

		return $this->display_OAI_PMH('https://ckan.lincoln.ac.uk/api/action/current_package_list_with_resources', $fields);
	}

	/**
	 * Displays OAI-PMH from datasets
	 *
	 * @return $OAI
	 * @access public
	 */

	function create_OAI_PMH($uri, $fields)
	{
		$datasets_data = json_decode($this->post_curl_request($uri, $fields));

		//Build xml
		$oai_xml = new SimpleXMLElement("<OAI-PMH></OAI-PMH>");
		$oai_xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$oai_xml->addAttribute('xsi:schemaLocation', 'http://www.openarchives.org/OAI/2.0/ http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd');
		$oai_xml->addAttribute('xmlns', 'http://www.openarchives.org/OAI/2.0/');
		$oai_xml->addChild('responseDate', date('now'));
		$oai_xml->addChild('request', 'http://eprints.lincoln.ac.uk/cgi/oai2');
		$oai_xml->addChild('ListRecords');

		foreach ($datasets_data->result as $data)
		{
			$record = $oai_xml->addChild('record');
			$header = $record->addChild('header');

			$header->addChild('identifier', '');
			$header->addChild('datestamp', date('now'));
			$header->addChild('setSpec', '7374617475733D707562');
			$header->addChild('setSpec', '7375626A656374733D6A6163735F47:6A6163735F47363030');
			$header->addChild('setSpec', '74797065733D636F6E666572656E63655F6974656D');
			$metadata = $record->addChild('metadata');
			$oai_dc = $metadata->addChild('oai_dc:dc');
			$oai_dc->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
			$oai_dc->addAttribute('xsi:schemaLocation', 'http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd');
			$oai_dc->addAttribute('xmlns:oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
			$oai_dc->addAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
			$oai_dc->addChild('title', $data->title);
			$oai_dc->addChild('creator', $data->author);
			$oai_dc->addChild('subject', '');
			$oai_dc->addChild('description', '');
			$oai_dc->addChild('type', $data->type);
			$oai_dc->addChild('type', $data->type);
			$oai_dc->addChild('format', '');
			$oai_dc->addChild('identifier', '');
			$oai_dc->addChild('format', '');
			$oai_dc->addChild('identifier', '');
			$oai_dc->addChild('identifier', '');
			$oai_dc->addChild('relation', '');
		}
		return $oai_xml->asxml();
	}
}