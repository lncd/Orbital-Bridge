<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CKAN Library
 *
 * Manages interfacing with CKAN.
 *
 * @category    Library
 * @package     Orbital
 * @subpackage  Manager
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
 */

class Sword {

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
	 * Sends SWORD object somewhere
	 */

	public function input($sword_input) //$sword_input, $library_to_send_it_to
	{
		//Get xml file contents
		$xml = file_get_contents($sword_input);

		$obj = new stdClass();

		$xml = explode("\n",$xml);

		$main_n = '';

		//Convert to object
		foreach ($xml as $x) {
			$first_n = false;
			$close_n = false;
			if ($x != '') {
				$start_val = (strpos($x,">")+1);
				$end_val = strrpos($x,"<") - $start_val;
				$start_n = (strpos($x,"<")+1);
				$end_n = strpos($x,">") - $start_n;
				$n = strtolower(substr($x,$start_n,$end_n));
				if (substr_count($x,"<") == 1) {
					if (!empty($main_n) && !stristr($n,"/")) {
						$submain_n = $n;
						$first_n = true;
					} else {
						$main_n = $n;
						$submain_n = '';
						$first_n = true;
					}
				}
				if (!empty($submain_n) && stristr($submain_n,"/")) {
					$submain_n = '';
					$first_n = false;
					$close_n = true;
				}
				if (!empty($main_n) && stristr($main_n,"/")) {
					$main_n = '';
					$submain_n = '';
					$first_n = false;
					$close_n = true;
				}
				$value = substr($x,$start_val,$end_val);
				if (!$close_n) {
					if (empty($main_n)) {
						$obj->$n = $value;
					} else {
						if ($first_n) {
							if (empty($submain_n)) {
								$obj->$main_n = new stdClass();
							} else {
								$obj->$main_n->$submain_n = new stdClass();
							}
						} else {
							if (!empty($value)) {
								if (empty($submain_n)) {
									$obj->$main_n->$n = $value;
								} else {
									$obj->$main_n->$submain_n->$n = $value;
								}
							}
						}
					}
				}
			}
		}

		//Make object array - Easier to convert to object first, then array
		$array = array();

		foreach($obj as $field=>$value)
		{
			$array[$field]=$value;
		}
		
		//Return the array
		return $array;
	}
}