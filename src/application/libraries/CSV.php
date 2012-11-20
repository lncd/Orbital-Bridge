<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSV Library
 *
 * CSV Library.
 *
 * @category    Library
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 */

class CSV {

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