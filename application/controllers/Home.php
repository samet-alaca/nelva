<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index() {
		$this->lang->load('home', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('home_page_title'),
			'description' => $this->lang->line('home_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('home', $data);
		$this->load->view('templates/footer');
	}

	public function landing() {
		$this->lang->load('home', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('home_page_title'),
			'description' => $this->lang->line('home_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('landing', $data);
		$this->load->view('templates/footer');
	}

	public function lang() {
		$this->session->set_userdata('lang', $this->input->post('lang'));
	}

	public function error() {
		$this->lang->load('error', $this->session->lang);

		$data['page'] = (object) [
			'title' => "Error - Royaume de Nelva",
			'description' => ""
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('error', $data);
		$this->load->view('templates/footer');
	}

	public function cinelva() {
		$data['page'] = (object) [
			'title' => "Cinelva",
			'description' => "",
			'links' => [
				base_url() . 'assets/style/player.css'
			],
			'scripts' => [
				base_url() . 'assets/js/player.js'
			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('cinelva', $data);
	}

	public function chronicles() {
		$data['page'] = (object) [
			'title' => "Chroniques",
			'description' => "",
			'links' => [

			],
			'scripts' => [

			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('chronicles', $data);
	}
}
