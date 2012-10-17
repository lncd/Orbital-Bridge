<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redirect extends CI_Controller {

	public function dataset($dataset)
	{
		redirect('http://id.lincoln.ac.uk/research-data/' . $dataset);
	}
}

// EOF