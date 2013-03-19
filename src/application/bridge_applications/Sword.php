<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SWORD Library
 *
 * Manages interfacing with SWORD endpoints.
 *
 * @category    Library
 * @package     Orbital
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Bridge
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
	 * Read ePrints
	 *
	 * Reads SWORD object and converts to bridge object
	 *
	 * string $sword_input URI of SWORD object to read
	 *
	 * @return object $bridge_object The standard bridge object
	 * @access public
	 */

	function read_eprints($sword_input) //$sword_input, $library_to_send_it_to
	{
		//Convert to object
		$obj = simplexml_load_file($sword_input);

		//Create Bridge-Object

		$bridge_object = array();
		foreach ($obj->eprint as $eprint_object)
		{
			$bridge->uri_slug = url_title($eprint_object->title, '_', TRUE);
			$bridge->title = (string) $eprint_object->title;
			$bridge->creators = array();
			foreach ($eprint_object->creators->item as $item)
			{
				$person->given_name = (string) $item->name->given;
				$person->family_name = (string) $item->name->family;
				$person->id = (string) $item->id;
				$bridge->creators[] = $person;
				unset($person);
			}
			$bridge->subjects = (string) $eprint_object->subjects->item;
			$bridge->publisher = (string) $eprint_object->publisher;
			$bridge->date = strtotime((string) $eprint_object->date);
			$bridge->type = "dataset";
			$bridge->keywords = array();
			foreach ($eprint_object->keywords->item as $keyword)
			{
				$bridge->keywords[] = (string) $keyword;
				unset($keyword);
			}
			$bridge->abstract = (string) $eprint_object->abstract;
			$bridge->data_type = (string) $eprint_object->data_type;
			$bridge->official_url = (string)$eprint_object->official_url;

			$bridge_object[] = $bridge;
			unset($bridge);
		}

		//Return the bridge object array
		return $bridge_object;
	}

	/**
	 * Creates SWORD object from bridge object
	 *
	 * array $dataset bridge object
	 *
	 * @return $eprint_xml->asXML()
	 * @access public
	 */

	function create_SWORD($dataset) //$standard bridge object
	{
		$permission_lookup = array(
			'creator' => 'http://www.loc.gov/loc.terms/relators/CRE',
			'contributor' => 'http://www.loc.gov/loc.terms/relators/CTB',
			'editor' => 'http://www.loc.gov/loc.terms/relators/EDT'
		);
	
		$eprint_xml = new SimpleXMLElement('<eprints xmlns="http://eprints.org/ep2/data/2.0"></eprints>');
		$eprint = $eprint_xml->addChild('eprint');
		//$eprint->addChild('eprintid', '1');
		//$eprint->addChild('rev_number', '2');
		//$eprint->addChild('eprint_status', 'archive');
		//$eprint->addChild('user_id', '1');
		//$eprint->addChild('dir', 'disk0/00/00/00/01');
		//$eprint->addChild('date_stamp', $bridge_object->date); //'2006-10-25 00:45:02'
		//$eprint->addChild('lastmod', '2006-10-25 00:45:02');
		//$eprint->addChild('status_changed', '2006-10-25 00:45:02');
		$eprint->addChild('title', $dataset->get_title()); //'On Testing The Atom Protocol...'
		$eprint->addChild('abstract', $dataset->get_abstract());
		$eprint->addChild('type', 'dataset');
		$eprint->addChild('data_type', $dataset->get_type_of_data());
		$eprint->addChild('official_url', $dataset->get_uri_slug()); //'www.example.com/data'
		$eprint->addChild('metadata_visibility', 'show');
		
		$creators = $eprint->addChild('creators');
		foreach($dataset->get_creators() as $creator)
		{
			$item = $creators->addChild('item');
			$name = $item->addChild('name');
			$name->addChild('family', $creator->last_name); //'Lericolais'
			$name->addChild('given', $creator->first_name); //'Y.'
			if(isset($permission_lookup[$creator->type]))
			{
				$item->addChild('type', $permission_lookup[$creator->type]);
			}
			if (isset($creator->id))
			{
				$item->addChild('id', $creator->id);
			}
		}
		$eprint->addChild('ispublished', $dataset->get_is_published());
		$subjects = $eprint->addChild('subjects');
		foreach($dataset->get_subjects() as $subject)
		{
			$subjects->addChild('item', (string) $subject); //'GR'
		}
		$keywords = $eprint->addChild('keywords');
		foreach($dataset->get_keywords() as $keyword)
		{
			$keywords->addChild('item', (string) $keyword); //'GR'
		}
		$divisions = $eprint->addChild('divisions');
		foreach($dataset->get_divisions() as $division)
		{
			$divisions->addChild('item', (string) $division); //'GR'
		}
		//$eprint->addChild('full_text_status', 'public');
		//$eprint->addChild('pres_type', 'paper');
		$eprint->addChild('date', $dataset->get_date());
		//$eprint->addChild('event_title', '4th Conference on Animal Things');
		//$eprint->addChild('event_location', 'Dallas, Texas');
		//$eprint->addChild('event_dates', 'event_dates');
		//$eprint->addChild('fileinfo', 'application/pdf;http://devel.eprints.org/1/01/paper.pdf');

		return($eprint_xml->asXML());
	}

	/**
	 * Create Dataset.
	 *
	 * string $username Username (Orbital superuser)
	 * string $password Password (Orbital Superusers password)
	 * array  $dataset  bridge object
	 *
	 * @return null
	 * @access public
	 */

	function create_dataset($dataset)
	{
		//$dataset = file_get_contents("/Users/hnewton/Desktop/test-import.xml");
		$sword_xml = $this->create_SWORD($dataset);

		$this->_ci->load->library('swordapp/swordappclient');
		return $this->_ci->swordappclient->depositEntryString($_SERVER['SWORD_ENDPOINT'], $_SERVER['SWORD_USER'], $_SERVER['SWORD_PASS'], '', $sword_xml, 'application/vnd.eprints.data+xml');

	}
}