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

	public function input($sword_input) //$sword_input, $library_to_send_it_to
	{
		//Get xml file contents
		$xml = file_get_contents($sword_input);

		$obj = new stdClass();

		$xml = explode("\n",$xml);

		$main_n = '';

		//Convert to object
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
	
	
	public function create($bridge_object) //$standard bridge object
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
		$documents = $eprint->addChild('documents');
		$document = $documents->addChild('document');
		$document->addAttribute('xmlns', 'http://eprints.org/ep2/data/2.0');
		$document->addChild('docid', '5');
		$document->addChild('rev_number', '1');
		$document->addChild('eprintid', '1');
		$document->addChild('pos', '1');
		$document->addChild('format', 'application/pdf');
		$document->addChild('language', 'en');
		$document->addChild('security', 'public');
		$document->addChild('main', 'paper.pdf');
		$files = $document->addChild('files');
		$file = $files->addChild('file');
		$file->addChild('filename', 'paper.pdf');
		$file->addChild('filesize', '12174');
		$file->addChild('url', 'http://devel.eprints.org/1/01/paper.pdf');
		$data = $file->addChild('data', 'JVBERi0xLjQNCiXk9tzfDQoxIDAgb2JqDQo8PCAvTGVuZ3RoIDIgMCBSDQogICAvRmlsdGVyIC9G bGF0ZURlY29kZQ0KPj4NCnN0cmVhbQ0KeJyVVctuGzEMvBvwP/Dcw0bUayXAKOBHfA9gID+QB5BD gebS36/SJSlbXCkufDKXIoczI8rAn+3mN5jyCzlMDpK38PkKzz/gF38w8Pm+3Rwu282ME0KIOHm4 vMDDGSEauLzBzuBPuHxsN36eQskvH3fGLiEXSjaF3BIKsYY8ZcVSmUKBQmmKHIoUMlPi0LyErC+g KZQolGpWFhCzPigd90sI8z24HgsRT5obLPQl8BkLAw05ByLHVhAValS4BqiOhMrVoU+S5Rrme0CN mTL4YCfLQNEuQB/NmaqFiotguEoqqcEZaDiDx0Oyg5yg/1ncgYRxLlC6VZzZy3i26sBHuwcHkKXK yqnMkPo56DknNvw75blah2WL9ZTliB5f6pxVL68qnxTCwDlztxe7r4q8wgbZ0Vc8vo9Zd28nlbq0 AxCL/bpjSZnQCqjgtVfqyrlaCDmlhRjY6awoVYgxssP7giJ1r3de3ROZYWBlzY2WKrZ1VqSiHDQj IbRTEuc41UxGz+MFlL6m8f8W8O0C4q2Q/g+SVuwuk2myxQypK2IVZFaC1MXFgrTPybD7Cmh2cF9p DWdwm3yfscGpwZ6/w9GM8OoV00tC32YxVV8K3Ld39/u3aoUv1RsPQ/ta/7U+PJr29dRrQq8b3UyI D017V+/TsRcRSvV74hUavSAHXv5eGpE832EmfWlPyl7HG9qf4C/TnC58ZW5kc3RyZWFtDQplbmRv YmoNCg0KMiAwIG9iag0KICA1MzENCmVuZG9iag0KDQo0IDAgb2JqDQo8PCAvTGVuZ3RoIDUgMCBS DQogICAvRmlsdGVyIC9GbGF0ZURlY29kZQ0KICAgL0xlbmd0aDEgMTY0MjgNCj4+DQpzdHJlYW0N Cnic5XsJfFTlveh3znfO7MuZNRshJwkhC5OFiSxhnZBMSCCbSVhbJJPMJJlsE2YmCQlS0BY3wBTB gJYWtFzaentrpNYiWIk26m3Vx2vF+nyt92pNtfRFXt971J+lcLj/7ztnsomWt9zfe7/fy2HmfMv/ ++/bl2g03BtABrQXYeRp7vL17N/R3oQQegMhxtrcFxWvfr8wCOP34XOkpae1682/3Ps7hHAUYPa3 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 ZSAvRm9udERlc2NyaXB0b3INCiAgIC9Gb250TmFtZSAvQkFBQUFBK0JpdHN0cmVhbVZlcmFTZXJp Zi1Sb21hbg0KICAgL0ZsYWdzIDQNCiAgIC9Gb250QkJveCBbIC0xODMgLTIzNSAxMjg2IDkyOCBd DQogICAvSXRhbGljQW5nbGUgMA0KICAgL0FzY2VudCA5MjgNCiAgIC9EZXNjZW50IC0yMzUNCiAg IC9DYXBIZWlnaHQgOTI4DQogICAvU3RlbVYgODANCiAgIC9Gb250RmlsZTIgNCAwIFINCj4+DQpl bmRvYmoNCg0KNyAwIG9iag0KPDwgL0xlbmd0aCAzNTcNCiAgIC9GaWx0ZXIgL0ZsYXRlRGVjb2Rl ID4+DQpzdHJlYW0NCnicXZLLaoNAFIb3gu8wy3QRdCZeEhAhMRFc9EJtH8DoMRXqKKNZ+PbV85tS ulG+ORfmm3OcJDtnuhmF82a6MqdR1I2uDA3d3ZQkrnRrtG1JJaqmHB/Iv7Itetty5vp8GkZqM113 IopsSwjnfU4YRjOJzbHqrvTEh6+mItPom9h8JjmO8nvff1NLehSubcWxqKheej4X/UvRknC4fJtV c0YzTtu58E/Kx9STUDiQuFvZVTT0RUmm0Deyrch1YxGlaWxbpKv/UXVA1bUuvwqzZMs523U9L15A MQQ+ww5wZvAAKYMPuDAEDOGOIQSg2x6gGA6okQxHwIHhhBsgkiCCbmdAwnBh8NE6RWS/gHQZlMsA Hx8AHy9gWH0A8AmRtvpwa7n6hAzw8fhBJHyCEwN8FL+BhE+I1vDZHRngo/jd5OoTYjaPGSxj4s36 XYLybsw8f15Anvsy8UbT75L2Xc916+cHZvyyu2VuZHN0cmVhbQ0KZW5kb2JqDQoNCjggMCBvYmoN Cjw8IC9UeXBlIC9Gb250DQogICAvU3VidHlwZSAvVHJ1ZVR5cGUNCiAgIC9CYXNlRm9udCAvQkFB QUFBK0JpdHN0cmVhbVZlcmFTZXJpZi1Sb21hbg0KICAgL0ZpcnN0Q2hhciAwDQogICAvTGFzdENo YXIgMjkNCiAgIC9XaWR0aHMgWyA2MDAgODAxIDU5MSA5NDggNjAyIDY0NCA1MTMgNDAxDQogICAg IDQ3OCA1OTYgMzE5IDcyMiA1NjAgMzE5IDY2NiA2NDQNCiAgICAgMzE3IDY3MiA2OTMgMzcwIDY0 MCA2NDAgODU1IDcyOQ0KICAgICA2MDUgMzE3IDU2NCAzMzYgMzM2IDY0MCBdDQogICAvRm9udERl c2NyaXB0b3IgNiAwIFINCiAgIC9Ub1VuaWNvZGUgNyAwIFINCj4+DQplbmRvYmoNCg0KOSAwIG9i ag0KPDwgL0YxIDggMCBSDQogICA+Pg0KZW5kb2JqDQoNCjEwIDAgb2JqDQo8PA0KICAgL0ZvbnQg OSAwIFINCiAgIC9Qcm9jU2V0IFsgL1BERiBdDQo+Pg0KZW5kb2JqDQoNCjExIDAgb2JqDQo8PCAv VHlwZSAvUGFnZQ0KICAgL1BhcmVudCAzIDAgUg0KICAgL1Jlc291cmNlcyAxMCAwIFINCiAgIC9N ZWRpYUJveCBbIDAgMCA1OTUgODQyIF0NCiAgIC9Db250ZW50cyAxIDAgUg0KPj4NCmVuZG9iag0K DQozIDAgb2JqDQo8PCAvVHlwZSAvUGFnZXMNCiAgIC9SZXNvdXJjZXMgMTAgMCBSDQogICAvTWVk aWFCb3ggWyAwIDAgNTk1IDg0MiBdDQogICAvS2lkcyBbIDExIDAgUg0KICAgICAgICAgICBdDQog ICAvQ291bnQgMQ0KPj4NCmVuZG9iag0KDQoxMiAwIG9iag0KPDwgL1R5cGUgL0NhdGFsb2cNCiAg IC9QYWdlcyAzIDAgUg0KPj4NCmVuZG9iag0KDQoxMyAwIG9iag0KPDwgL0F1dGhvciA8RkVGRjAw NDMwMDY4MDA3MjAwNjkwMDczMDA3NDAwNkYwMDcwMDA2ODAwNjUwMDcyMDAyMDAwNDcwMDc1MDA3 NDAwNzQwMDY1MDA3MjAwNjkwMDY0MDA2NzAwNjU+DQovQ3JlYXRvciA8RkVGRjAwNTcwMDcyMDA2 OTAwNzQwMDY1MDA3Mj4NCi9Qcm9kdWNlciA8RkVGRjAwNEYwMDcwMDA2NTAwNkUwMDRGMDA2NjAw NjYwMDY5MDA2MzAwNjUwMDJFMDA2RjAwNzIwMDY3MDAyMDAwMzEwMDJFMDAzMTAwMkUwMDMxPg0K L0NyZWF0aW9uRGF0ZSAoRDoyMDA1MDQyMjE3MDkxNyswMScwMCcpDQo+Pg0KZW5kb2JqDQoNCnhy ZWYNCjAgMTQNCjAwMDAwMDAwMDAgNjU1MzUgZg0KMDAwMDAwMDAxNyAwMDAwMCBuDQowMDAwMDAw NjMzIDAwMDAwIG4NCjAwMDAwMTEyODggMDAwMDAgbg0KMDAwMDAwMDY1OSAwMDAwMCBuDQowMDAw MDA5OTkxIDAwMDAwIG4NCjAwMDAwMTAwMTYgMDAwMDAgbg0KMDAwMDAxMDI2OSAwMDAwMCBuDQow MDAwMDEwNzA4IDAwMDAwIG4NCjAwMDAwMTEwNTIgMDAwMDAgbg0KMDAwMDAxMTA5MiAwMDAwMCBu DQowMDAwMDExMTU4IDAwMDAwIG4NCjAwMDAwMTE0MjYgMDAwMDAgbg0KMDAwMDAxMTQ4NiAwMDAw MCBuDQp0cmFpbGVyDQo8PCAvU2l6ZSAxNA0KICAgL1Jvb3QgMTIgMCBSDQogICAvSW5mbyAxMyAw IFINCj4+DQpzdGFydHhyZWYNCjExNzk3DQolJUVPRg0K');
		$data->addAttribute('encoding', 'base64');
		
		return($eprint_xml->asXML());
	}
}