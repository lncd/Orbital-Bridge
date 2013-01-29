<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * N2 Library
 *
 * Manages interfacing with N2.
 *
 * @category    Controller
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
 */

class N2 
{

	private $client;

	public function __construct()
	{
		$this->client = new Nucleus\Client(array(
	    	'access_token' => '123456'
	    ));
	}

	public function __call($method, $params)
    {
    
    	if (isset($params[0]))
    	{
	    	return $this->client->$method($params[0]);
	    }
	    else
	    {
		    return $this->client->$method();
	    }
    }

}