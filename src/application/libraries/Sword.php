<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CKAN Library
 *
 * Manages interfacing with CKAN.
 *
 * @category    Library
 * @package     Orbital
 * @subpackage  Manager
 * @author      Harry Newton <hnewton@lincoln.ac.uk>
 * @link        https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
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
	 * Sends SWORD object somewhere
	 */

	public function read($sword_input) //$sword_input, $library_to_send_it_to
	{
		//Get xml file contents
		$xml = file_get_contents($sword_input);

		$obj = new stdClass();

		$xml = explode("\n",$xml);

		$main_n = '';

		//Convert to object
		// $xml = simplexml_load_file('test.xml');
		
		//old convert to object - use simpleXML?
		foreach ($xml as $x)
		{
			$first_n = false;
			$close_n = false;
			if ($x != '')
			{
				$start_val = (strpos($x,">")+1);
				$end_val = strrpos($x,"<") - $start_val;
				$start_n = (strpos($x,"<")+1);
				$end_n = strpos($x,">") - $start_n;
				$n = strtolower(substr($x,$start_n,$end_n));
				if (substr_count($x,"<") == 1)
				{
					if (!empty($main_n) && !stristr($n,"/"))
					{
						$submain_n = $n;
						$first_n = true;
					}
					else
					{
						$main_n = $n;
						$submain_n = '';
						$first_n = true;
					}
				}
				if (!empty($submain_n) && stristr($submain_n,"/"))
				{
					$submain_n = '';
					$first_n = false;
					$close_n = true;
				}
				if (!empty($main_n) && stristr($main_n,"/"))
				{
					$main_n = '';
					$submain_n = '';
					$first_n = false;
					$close_n = true;
				}
				$value = substr($x,$start_val,$end_val);
				if (!$close_n)
				{
					if (empty($main_n))
					{
						$obj->$n = $value;
					}
					else
					{
						if ($first_n)
						{
							if (empty($submain_n))
							{
								$obj->$main_n = new stdClass();
							}
							else
							{
								$obj->$main_n->$submain_n = new stdClass();
							}
						}
						else
						{
							if (!empty($value))
							{
								if (empty($submain_n))
								{
									$obj->$main_n->$n = $value;
								}
								else
								{
									$obj->$main_n->$submain_n->$n = $value;
								}
							}
						}
					}
				}
			}
		}
		
		$bridge->uri_slug = url_title($obj->title, '_', TRUE);
		$bridge->author = $obj->creators_name->item->given . ' ' . $obj->creators_name->item->family;
		$bridge->title = $obj->title;
		
		//Return the array
		return $bridge;
	}
	
		
	
	public function create_SWORD($bridge_object) //$standard bridge object
	{
		$eprint_xml = new SimpleXMLElement("<eprints></eprints>");
		$eprint = $eprint_xml->addChild('eprint');
		$eprint->addAttribute('xmlns', 'http://eprints.org/ep2/data/2.0');
		$eprint->addChild('eprintid', '1');
		$eprint->addChild('rev_number', '2');
		$eprint->addChild('eprint_status', 'archive');
		$eprint->addChild('user_id', '1');
		$eprint->addChild('dir', 'disk0/00/00/00/01');
		$eprint->addChild('date_stamp', '2006-10-25 00:45:02');
		$eprint->addChild('lastmod', '2006-10-25 00:45:02');
		$eprint->addChild('status_changed', '2006-10-25 00:45:02');
		$eprint->addChild('type', 'conference_item');
		$eprint->addChild('metadata_visibility', 'show');
		$creators_name = $eprint->addChild('creators_name');
		$item = $creators_name->addChild('item');
		$item->addChild('family', 'Lericolais');
		$item->addChild('given', 'Y.');
		$eprint->addChild('title', 'On Testing The Atom Protocol...');
		$eprint->addChild('ispublished', 'pub');
		$subjects = $eprint->addChild('subjects');
		$subjects->addChild('item', 'GR');
		$subjects->addChild('item', 'QR');
		$subjects->addChild('item', 'BX');
		$subjects->addChild('item', 'PN2000');
		$eprint->addChild('full_text_status', 'public');
		$eprint->addChild('pres_type', 'paper');
		$eprint->addChild('abstract', 'This is where the abstract of this record would appear. This is only demonstration data.');
		$eprint->addChild('date', '1998');
		$eprint->addChild('event_title', '4th Conference on Animal Things');
		$eprint->addChild('event_location', 'Dallas, Texas');
		$eprint->addChild('event_dates', 'event_dates');
		$eprint->addChild('fileinfo', 'application/pdf;http://devel.eprints.org/1/01/paper.pdf');
				
		return($eprint_xml->asXML());
	}
	
	/**
	 * Create Dataset.
	 *
	 * @variable object $config  
	 * @variable object $archive
	 */
	
	function create_dataset($username = "sword-test", $password = "sword-test", $dataset)
	{
		//$dataset = file_get_contents("/Users/hnewton/Desktop/test-import.xml");
		$sword_xml = $this->create_SWORD($dataset);

		$host     = "eprints.lincoln.ac.uk";
		$endpoint = "sword-app/deposit";
		$collection = "inbox"; # could be "review" or "inbox"
		$url = "http://" . $username . ":" . $password . "@"
			. $host . "/" . $endpoint . "/" . $collection;


		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, strlen($sword_xml));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $sword_xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'X-On-Behalf-Of: sword-test'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute post
		$result = curl_exec($ch);
		print_r(curl_getinfo($ch));

		//close connection
		curl_close($ch);

		var_dump($result);

	}
}