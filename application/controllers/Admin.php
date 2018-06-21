<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('User_model');
	}

	public function index() {
		$this->lang->load('admin', $this->session->lang);
		$data['page'] = (object) [
			'title' => $this->lang->line('admin_page_title'),
			'description' => $this->lang->line('admin_page_description'),
			'links' => [
				'//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.css',
				'//cdnjs.cloudflare.com/ajax/libs/tabulator/3.4.6/css/tabulator.min.css'
			],
			'scripts' => [
				'//cdn.jsdelivr.net/momentjs/latest/moment.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js',
				base_url() . 'assets/library/autocomplete/dist/jquery.autocomplete.min.js',
				base_url() . 'assets/js/admin.js'
			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		if(!$this->session->isAdmin) {
			redirect('/error');
		}
		$data['roles'] = $this->User_model->getRoles();
		$data['members'] = $this->Admin_model->getMembers();
		//$this->dd($data['members']);
		$this->load->view('templates/header', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}

	public function postNotify() {
		$role = $this->input->post('role');
		$message = $this->input->post('message');
		if($this->session->isAdmin && $role && $message) {
			$this->Admin_model->sendNotify($role, $message);
		}
	}

	public function getBestiaire() {
		$user = $this->input->post('pseudo');
		$id = $this->input->post('id');
		$p = $this->input->post('p');
		$m = $this->input->post('m');
		if($user) {
			echo json_encode($this->Admin_model->getBest($user));
		} elseif($id && $this->session->isAdmin) {
			$this->Admin_model->deleteBestiaire($id);
		} elseif($p && $m && $this->session->isAdmin) {
			$this->Admin_model->addBestiaire($p, $m, $this->session->user->username);
		} else {
			echo json_encode($this->Admin_model->getBestiaire());
		}
	}

	public function discordStats() {
		$period = $this->input->post('period');
		if($period) {
			echo json_encode($this->Admin_model->getDiscordStats($period));
		}
	}
}
