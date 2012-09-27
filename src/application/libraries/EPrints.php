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

class Eprints {

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

	public function import_SWORD_to_EPrints()
	{
		//CURRENTLY BEING TESTED - SEE test_EPrints_SWORD controller
	}
}