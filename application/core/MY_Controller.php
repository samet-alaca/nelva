<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if(!isset($this->session)) {
			$this->load->library('session');
		}

		if(!$this->session->lang) {
			$this->session->set_userdata('lang', 'fr');
		}
		$this->lang->load('template', $this->session->lang);

		$this->load->helper('cookie');
		$this->load->helper('url');
	}

	public function dd($v) {
		echo "<pre>";
		print_r($v);
		echo "<pre>",
		die();
	}

	public function getRedirectUri() {
		return 'http://nelva.fr/signin';
	}

	public function getAuthUrl() {
		require_once('./vendor/autoload.php');
		$provider = new \Wohali\OAuth2\Client\Provider\Discord([
			'clientId' => '282165070706900992',
			'clientSecret' => '',
			'redirectUri' => $this->getRedirectUri()
		]);

		return $provider->getAuthorizationUrl([
			'scope' => [ 'identify', 'guilds' ]
		]);
	}
}
