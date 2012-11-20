<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv {

	public $configuration = '{
		"name": "CSV",
		"multi_instance": false,
		"config_keys": [],
		"objects": {
			"tabular": {
				"convert": {
					"accepts": [
						"text"
					],
					"config_keys": []
				}
			},
			"text": {
				"convert": {
					"accepts": [
						"tabular"
					],
					"config_keys": []
				}
			}
		}
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