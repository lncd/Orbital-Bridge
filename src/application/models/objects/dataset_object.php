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

	protected $_url;
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
	protected $_type_of_data;
	protected $_divisions;
	protected $_doi;
	
	//Get and SET $url
	public function set_url($url)
	{
		$this->_url = $url;
		return TRUE;
	}
	
	public function get_url()
	{
		return $this->_url;
	}
	
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
	
	//UNSET $creators
	public function unset_creators()
	{
		unset($this->_creators);
		return TRUE;
	}
	
	//Get and SET $creators
	public function add_creator($name, $type, $id)
	{
		$creator = new stdClass;
		try
		{
			$names = explode(' ', $name, 2);
		
			$creator->first_name = $names[0];
			$creator->last_name = $names[1];
		}
		catch (Exception $e)
		{
			$creator->last_name = $name;
		}
		$creator->type = $type;
		$creator->id = $id;
	
		$this->_creators[] = $creator;
		return TRUE;
	}
	
	public function get_creators()
	{
		return $this->_creators;
	}
	
	//UNSET $subjects
	public function unset_subjects()
	{
		unset($this->_subjects);
		return TRUE;
	}
	
	//Get and SET $subjects
	public function add_subject($subject)
	{
		$this->_subjects[] = $subject;
		return TRUE;
	}
	
	public function get_subjects()
	{
		return $this->_subjects;
	}
	
	//UNSET $divisions
	public function unset_divisions()
	{
		unset($this->_divisions);
		return TRUE;
	}
	
	//Get and SET $divisions
	public function add_division($division)
	{
		$this->_divisions[] = $division;
		return TRUE;
	}
	
	public function divisions()
	{
		return $this->_divisions;
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
	
	//UNSET $keywords
	public function unset_keywords()
	{
		unset($this->_keywords);
		return TRUE;
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
	public function get_metadata_visibility()
	{
		return $this->_metadata_visibility;
	}
	
	//Get and SET $publisher
	public function set_publisher($publisher)
	{
		$this->_publisher = $publisher;
		return TRUE;
	}
	
	public function get_publisher()
	{
		return $this->_publisher;
	}
	
	//Get and SET $publication_date
	public function set_publication_date($publication_date)
	{
		$this->_publication_date = $publication_date;
		return TRUE;
	}
	
	public function get_publication_date()
	{
		return $this->_publication_date;
	}
	
	public function get_publication_date_timestamp()
	{
		return strtotime($this->_publication_date);
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
	//Get and SET $type_of_data
	public function set_type_of_data($type_of_data)
	{
		$this->_type_of_data = $type_of_data;
		return TRUE;
	}
	public function get_type_of_data()
	{
		return $this->_type_of_data;
	}
	
	//Get and SET $divisions
	public function set_divisions($divisions)
	{
		$this->_divisions = $divisions;
		return TRUE;
	}
	public function get_divisions()
	{
		return $this->_divisions;
	}
	
	//Get SET and Mint $DOI
	public function set_doi($doi)
	{
		$this->_doi = $doi;
		return TRUE;
	}
	public function get_doi()
	{
		return $this->_doi;
	}
	public function mint_doi()
	{
		$chars = "ABCDEFGHJKLMNPQRSTUXYZ23456789";
		$doi_string = '';
		
		for($i=0; $i<6; $i++)
		{
			$doi_string .= $chars[rand(0, strlen($chars) - 1)];
		}
		
		$doi = $_SERVER['DATACITE_PREFIX'] . '/' . date('Y', $this->get_publication_date_timestamp()) . '.' . $doi_string;
	
		$doi_xml = new SimpleXMLElement('<resource xmlns="http://datacite.org/schema/kernel-2.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://datacite.org/schema/kernel-2.2 http://schema.datacite.org/meta/kernel-2.2/metadata.xsd"></resource>');
		$doi_doi = $doi_xml->addChild('identifier', $doi);
		$doi_doi->addAttribute('identifierType', 'DOI');
		
		$creators = $doi_xml->addChild('creators');
		
		foreach($this->get_creators() as $creator)
		{
			$creator_child = $creators->addChild('creator');
			$creator_child->addChild('creatorName', $creator->last_name . ', ' . $creator->first_name);
		}
		
		$titles = $doi_xml->addChild('titles');
		$titles->addChild('title', $this->get_title());
		$doi_xml->addChild('publisher', 'University of Lincoln');
		$doi_xml->addChild('publicationYear', date('Y', $this->get_publication_date_timestamp()));

		$post_xml = $doi_xml->asXML();

		$url = $_SERVER['DATACITE_URL'] . '/mds/metadata';

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, strlen($post_xml));
		curl_setopt($ch, CURLOPT_USERPWD, $_SERVER['DATACITE_USER'] . ":" . $_SERVER['DATACITE_PASS']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute post
		$result = curl_exec($ch);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		//close connection
		curl_close($ch);
		
		if($status === 201)
		{
			$url = $_SERVER['DATACITE_URL'] . '/mds/doi';
		
			$post_field = 'doi='. urlencode($doi) . '&url=' . urlencode($this->get_url());
		
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, strlen($post_field));
			curl_setopt($ch, CURLOPT_USERPWD, $_SERVER['DATACITE_USER'] . ":" . $_SERVER['DATACITE_PASS']);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
			//execute post
			$result = curl_exec($ch);
			
			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			//close connection
			curl_close($ch);
					
			if($status === 201)
			{
				$this->set_doi($doi);
				return TRUE;				
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}		
	}
}