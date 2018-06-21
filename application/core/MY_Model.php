<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getRedirectUri() {
		return 'http://nelva.fr/signin';
	}

	public function dd($v) {
		echo "<pre>";
		print_r($v);
		echo "<pre>",
		die();
	}
}
