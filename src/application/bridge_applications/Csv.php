<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv {

	public $configuration = '{
		"name": "CSV",
		"multi_instance": false,
		"config_keys": [],
		"objects": {
			"tabular": {
				"convert": {
					"accepts": [
						"text"
					],
					"config_keys": []
				}
			},
			"text": {
				"convert": {
					"accepts": [
						"tabular"
					],
					"config_keys": []
				}
			}
		}
	}';

}