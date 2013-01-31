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
	public function __call($method, $params)
    {
		$client = new Nucleus\Client(array(
	    	'access_token' => $params[0],
	    	'base_url' => $_SERVER['NUCLEUS_BASE_URI']
	    ));

    	if (isset($params[1]))
    	{
	    	return $client->$method($params[1]);
	    }
	    else
	    {
		    return $client->$method();
	    }
    }
}