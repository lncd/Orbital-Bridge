<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv {

	public $configuration = '{
	"name": "CSV",
	"multi_instance": false,
	"config_keys": [],
	"functions": [
	    {
	        "read_csv": {
	            "name": "Read CSV",
	            "description": "Reads CSV content and outputs it as an object ",
	            "accepts": [
	                {
	                    "name": "url",
	                    "description": "Location of CSV content",
	                    "type": "text"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$output",
	                    "description": "CSV converted to an array of arrays",
	                    "type": "array"
	                }
	            ]
	        },
	        "convert_tabular_to_text": {
	            "name": "Convert tabular data to text",
	            "description": "Converts tabular data to text ",
	            "accepts": [
	                {
	                    "name": "$bridge_object",
	                    "description": "object in tabular format",
	                    "type": "object"
	                }
	            ],
	            "returns": [
	                {
	                    "name": "$output",
	                    "description": "Text output",
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
	 * Reads CSV and converts to bridge object
	 *
	 * string $url URI of CSV to read
	 *
	 * @return object $bridge_object The standard bridge object
	 * @access public
	 */

	public function read_csv($url)
	{
		//Output as array of arrays
		$rows = explode("\n", file_get_contents($url));
		$output = array();

		foreach($rows as $row)
		{
			$output[] = explode(",", $row);
		}
		return $output;
	}

	/**
	 * Creates CSV from bridge object
	 *
	 * string $bridge_object Bridge Object to convert to CSV
	 *
	 * @return object $csv CSV output
	 * @access public
	 */

	public function convert_tabular_to_text($bridge_object)
	{
		$output = '';
		foreach($bridge_object as $array_item)
		{
			$output .= implode(",", $array_item) . "\n";
		}
		return $output;
	}
}