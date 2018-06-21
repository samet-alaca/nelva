<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academy extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Nexus_model');
		$this->load->model('User_model');
	}

	public function index() {
		$this->lang->load('academy', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('academy/index', $data);
		$this->load->view('templates/footer');
	}

	public function military() {
		$this->lang->load('academy', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$data['courses'] = $this->Nexus_model->getCourses("military");

		$this->load->view('templates/header', $data);
		$this->load->view('academy/list', $data);
		$this->load->view('templates/footer');
	}

	public function economy() {
		$this->lang->load('academy', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$data['courses'] = $this->Nexus_model->getCourses("economy");

		$this->load->view('templates/header', $data);
		$this->load->view('academy/list', $data);
		$this->load->view('templates/footer');
	}

	public function diplomacy() {
		$this->lang->load('academy', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$data['courses'] = $this->Nexus_model->getCourses("diplomacy");

		$this->load->view('templates/header', $data);
		$this->load->view('academy/list', $data);
		$this->load->view('templates/footer');
	}

	public function leadership() {
		$this->lang->load('academy', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description')
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$data['courses'] = $this->Nexus_model->getCourses("leadership");

		$this->load->view('templates/header', $data);
		$this->load->view('academy/list', $data);
		$this->load->view('templates/footer');
	}

	public function get($slug) {
		$this->lang->load('academy', $this->session->lang);
		$data['page'] = (object) [
			'title' => $this->lang->line('academy_page_title'),
			'description' => $this->lang->line('academy_page_description'),
			'scripts' => [
				base_url() . 'assets/js/document.js'
			]
		];
		$data['slug'] = $slug;
		$document = $this->Nexus_model->get($slug);

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		if($document) {
			$document->author = $this->User_model->get($document->author);
			$document->author->rank = $this->User_model->getRank($document->author->user->id);
			$data['document'] = $document;
			$data['page']->title = $document->title . ' - Royaume de Nelva';
			$data['page']->description = $document->description;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('academy/document', $data);
		$this->load->view('templates/footer');
	}
}
