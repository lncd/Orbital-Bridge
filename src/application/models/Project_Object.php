<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Project_Object Library
 *
 * Manages the Project Bridge Object.
 *
 * @category   Library
 * @package    Orbital
 * @subpackage Manager
 * @autho      Harry Newton <hnewton@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
 */

class Project_Object {

	protected $_title;
	protected $_summary;
	protected $_project_lead;
	protected $_college;
	protected $_school;
	protected $_funding_type;
	protected $_funding_body;
	protected $_start_date;
	protected $_end_date;
	protected $_currency;
	protected $_submission_date;
	protected $_uri_slug;
	
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
	
	//Get and SET $summary
	public function set_summary($summary)
	{
		$this->_summary[] = $summary;
		return TRUE;
	}
	
	public function get_summary()
	{
		return $this->_summary;
	}
	
	//Get and SET $project_lead
	public function set_project_lead($project_lead)
	{
		$this->_project_lead = $project_lead;
		return TRUE;
	}
	
	public function get_project_lead()
	{
		return $this->_project_lead;
	}
	
	//Get and SET $college
	public function set_college($college)
	{
		$this->_college = $college;
		return TRUE;
	}
	
	public function get_college()
	{
		return $this->_college;
	}
	
	//Get and SET $school
	public function set_school($school)
	{
		$this->_school[] = $school;
		return TRUE;
	}
	
	public function get_school()
	{
		return $this->_school;
	}
	
	//Get and SET $funding_type
	public function set_funding_type($funding_type)
	{
		$this->_funding_type[] = $funding_type;
		return TRUE;
	}
	
	public function get_funding_type()
	{
		return $this->_funding_type;
	}
	
	//Get and SET $funding_body
	public function set_funding_body($funding_body)
	{
		$this->_funding_body[] = $funding_body;
		return TRUE;
	}
	
	public function get_funding_body()
	{
		return $this->_funding_body;
	}
	
	//Get and SET $start_date
	public function set_start_date($start_date)
	{
		$this->_start_date[] = $start_date;
		return TRUE;
	}
	
	public function get_start_date()
	{
		return $this->_start_date;
	}
	
	//Get and SET $end_date
	public function set_end_date($end_date)
	{
		$this->_end_date[] = $end_date;
		return TRUE;
	}
	
	public function get_end_date()
	{
		return $this->_end_date;
	}
	
	//Get and SET $currency
	public function set_currency($currency)
	{
		$this->_currency[] = $currency;
		return TRUE;
	}
	
	public function get_currency()
	{
		return $this->_currency;
	}
	
	//Get and SET $submission_date
	public function set_submission_date($submission_date)
	{
		$this->_submission_date = $submission_date;
		return TRUE;
	}
	
	public function get_submission_date()
	{
		return $this->_submission_date;
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
}