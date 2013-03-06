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
	protected $_metadata_visibility;
	protected $_is_published;
	protected $_contributor;
	protected $_publication_date;
	protected $_language;
	protected $_size;
	protected $_format;
	protected $_version;
	protected $_abstract;
	
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
	
	//Get and SET $metadata_visibility
	public function set_metadata_visibility($metadata_visibility)
	{
		$this->_metadata_visibility = $metadata_visibility;
		return TRUE;
	}
	
	//Get and SET $publication_date
	public function set_publication_date($date)
	{
		$this->_publication_date = $publication_date;
		return TRUE;
	}
	
	public function get_publication_date()
	{
		return $this->_publication_date;
	}
	public function get_metadata_visibility()
	{
		return $this->_metadata_visibility;
	}
		
	//Get and SET $is_published
	public function set_is_published($is_published)
	{
		$this->_is_published = $is_published;
		return TRUE;
	}
	public function get_is_published()
	{
		return $this->_is_published;
	}
	
	//Get and SET $contributor
	public function set_contributor($contributor)
	{
		$this->_contributor = $contributor;
		return TRUE;
	}
	public function get_contributor()
	{
		return $this->_contributor;
	}
	
	//Get and SET $language
	public function set_language($language)
	{
		$this->_language = $language;
		return TRUE;
	}
	public function get_language()
	{
		return $this->_language;
	}
	//Get and SET $size
	public function set_size($size)
	{
		$this->_size = $size;
		return TRUE;
	}
	public function get_size()
	{
		return $this->_size;
	}
	//Get and SET $format
	public function set_format($format)
	{
		$this->_format = $format;
		return TRUE;
	}
	public function get_format()
	{
		return $this->_format;
	}
	//Get and SET $version
	public function set_version($version)
	{
		$this->_version = $version;
		return TRUE;
	}
	public function get_version()
	{
		return $this->_version;
	}
	//Get and SET $abstract
	public function set_abstract($abstract)
	{
		$this->_abstract = $abstract;
		return TRUE;
	}
	public function get_abstract()
	{
		return $this->_abstract;
	}
}