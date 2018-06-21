<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('User_model');
	}

	public function signin() {
		$response = $this->User_model->signin($this->input->get('code'));
		if($response) {
			$this->session->logged = true;
			redirect('/');
		} else {
			redirect('/error');
		}
		redirect('/');
	}

	public function color_format($in) {
		$hex = str_pad(dechex($in), 6, 0, STR_PAD_LEFT);
		$hex = mb_substr($hex,0,2) . mb_substr($hex,2,2) . mb_substr($hex,4,2);
		return ($hex == "000000") ? '#6c757d' : '#'.$hex;
	}

	public function roles_format($user, $serverRoles) {
		$roles = [];
		foreach($user->roles as $role) {
			foreach($serverRoles as $sRole) {
				if($role == $sRole->id) {
					$sRole->color = $this->color_format($sRole->color);
					$roles[] = $sRole;
				}
			}
		}
		$user->roles = $roles;
		return $user;
	}

	public function users() {
		$this->lang->load('users', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('users_page_title'),
			'description' => $this->lang->line('users_page_description'),
			'scripts' => [
				base_url() . 'assets/js/users.js'
			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('users/index', $data);
		$this->load->view('templates/footer');
	}

	public function usersWrap() {
		$data['members'] = $this->User_model->getMembers();
		$this->load->view('users/members', $data);
	}

	public function user($id) {
		$this->lang->load('users', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('users_page_title'),
			'description' => $this->lang->line('users_page_description'),
			'links' => [
				'//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.css'
			],
			'scripts' => [
				'//cdn.jsdelivr.net/momentjs/latest/moment.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.27/daterangepicker.min.js',
				'//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js',
				base_url() . 'assets/js/profile.js'
			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$period = $this->input->post('period');
		if($period) {
			echo json_encode($this->User_model->getDiscordStats($id, $period));
		} else {
			$user = $this->roles_format($this->User_model->get($id), $this->User_model->getRoles());
			$user->rank = $this->User_model->getRank($user->user->id);

			if(!$user->rank) {
				$user->rank = (object) [
					'm' => 5,
					'l' => 5,
					'e' => 5,
					'd' => 5,
					'i' => 5,
					'setting' => '1'
				];
			}

			$data['user'] = $user;
			$this->load->view('templates/header', $data);
			$this->load->view('users/user', $data);
			$this->load->view('templates/footer');
		}
	}

	public function usernames() {
		echo json_encode($this->User_model->listGuildMembers());
	}
}
