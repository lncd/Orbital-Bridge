<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OwnCloud Library
 *
 * Manages interfacing with OwnCloud.
 *
 * @category    Library
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 *
 * @todo Write library.
 */

class Owncloud {

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
}