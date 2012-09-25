<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Static Page Controller
 *
 * Loads view templates for static page content.
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Harry Newton <hnewton@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Bridge
*/

class Static_Content extends CI_Controller {

	private $data = array();

	/**
	 * Constructor
	*/

	function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * Index
	 *
	 * Default home page
	*/

	function index()
	{
	
		$this->lang->load('marketing');
		
		$this->data['page_title'] = 'Welcome';
	
		$this->load->view('includes/header', $this->data);
		$this->load->view('home', $this->data);
		$this->load->view('includes/footer', $this->data);
	}
}