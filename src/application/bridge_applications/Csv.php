<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv {

	public $configuration = array(
		'name'				=> 'CSV',
		'multi_instance'	=> FALSE,
		'config_keys'		=> array(
		),
		'objects'			=> array(
			'tabular'			=> array(
				'convert'			=> array(
					'accepts'			=> array(
						'text'
					),
					'config_keys'		=> array(
					)
				),
			),
			'text'				=> array(
				'convert'			=> array(
					'accepts'			=> array(
						'tabular'
					),
					'config_keys'		=> array(
					)
				)
			)
		)
	);

}