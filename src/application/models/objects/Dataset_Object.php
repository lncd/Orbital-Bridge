<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bridge_Object Library
 *
 * Manages the Dataset Bridge Object.
 *
 * @category   Library
 * @package    Orbital
 * @subpackage Manager
 * @autho      Harry Newton <hnewton@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
 */

class Dataset_Object {

	protected $_title;	
	protected $_uri_slug;
	protected $_creators;
	protected $_subjects; //JACS CODES
	protected $_date;
	protected $_keywords = array();
	
	//Get and SET $title
	public function set_title($title)
	{
		$this->_title = $title;
		return TRUE;
	}
	
	public function get_title()
	{
		return $this->_title;
	}
	
	//Get and SET $uri_slug
	public function set_uri_slug($uri_slug)
	{
		$this->_uri_slug = $uri_slug;
		return TRUE;
	}
	
	public function get_uri_slug()
	{
		return $this->_uri_slug;
	}
	
	//Get and SET $creators
	public function set_creator($creator)
	{
		$this->_creators[] = $creator;
		return TRUE;
	}
	
	public function get_creators()
	{
		return $this->_creators;
	}
	
	//Get and SET $subjects
	public function set_subjects($subjects)
	{
		$this->_subjects = $subjects;
		return TRUE;
	}
	
	public function get_subjects()
	{
		return $this->_subjects;
	}
	
	//Get and SET $date
	public function set_date($date)
	{
		$this->_date = $date;
		return TRUE;
	}
	
	public function get_date()
	{
		return $this->_date;
	}
	
	//Get and SET $keywords
	public function add_keyword($keyword)
	{
		$this->_keywords[] = $keyword;
		return TRUE;
	}
	
	public function get_keywords()
	{
		return $this->_keywords;
	}
}