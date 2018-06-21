<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nexus extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Nexus_model');
		$this->load->model('User_model');
	}

	public function index() {
		$this->lang->load('nexus', $this->session->lang);

		$data['page'] = (object) [
			'title' => $this->lang->line('nexus_page_title'),
			'description' => $this->lang->line('nexus_page_description'),
			'scripts' => [
				base_url() . 'assets/library/jquery.shuffle.min.js',
				base_url() . 'assets/library/jquery.ba-throttle-debounce.min.js',
				base_url() . 'assets/js/nexus.js'
			],
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$data['documents'] = $this->Nexus_model->getAll();
		$data['categories'] = $this->Nexus_model->getCategories();

		$this->load->view('templates/header', $data);
		$this->load->view('nexus/index', $data);
		$this->load->view('templates/footer');
	}

	public function get($slug) {
		$this->lang->load('nexus', $this->session->lang);
		$data['page'] = (object) [
			'title' => $this->lang->line('nexus_page_title'),
			'description' => $this->lang->line('nexus_page_description'),
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
		$this->load->view('nexus/document', $data);
		$this->load->view('templates/footer');
	}

	public function create() {
		$this->lang->load('nexus', $this->session->lang);
		$data['page'] = (object) [
			'title' => "Nouveau document - Nexus - Royaume de Nelva",
			'description' => "Créez un nouveau document - Royaume de Nelva",
			'links' => [
				base_url() . 'assets/library/fileinput/css/fileinput.min.css'
			],
			'scripts' => [
				'https://cdn.ckeditor.com/4.6.2/full/ckeditor.js',
				base_url() . 'assets/library/atwho/atwho.min.js',
				base_url() . 'assets/library/fileinput/js/plugins/piexif.min.js',
				base_url() . 'assets/library/fileinput/js/fileinput.min.js',
				base_url() . 'assets/js/create_document.js',
			]
		];

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$content = $this->input->post('content');
		$extension = $this->input->post('extension');
		$courseType = $this->input->post('courseType');
		$courseRank = $this->input->post('courseRank');
		$category = $this->input->post('category');
		$order = $this->input->post('courseOrder');

		if($title) {
			$errors = array();

			if(!$this->session->logged || !$this->session->isMember) {
				$errors[] = "Vous n'êtes pas autorisés à créer un document.";
			}

			$title_length = strlen($title);
			if($title_length < 5 || $title_length > 60) {
				$errors[] = "Titre trop court ou trop long (5 < titre > 60).";
			}

			if($description && strlen($description) > 100) {
				$errors[] = "Description trop longue (max 100 caractères).";
			}

			if(!$content || strlen($content) < 5) {
				$errors[] = "Contenu vide ou trop court.";
			}

			if(!$this->session->logged) {
				$errors[] = "Vous n'êtes pas autorisés à créer un document.";
			}

			if(empty($errors)) {
				try {
					$slug = $this->Nexus_model->create($title, $description, $content, $extension, ($category == '["coursjeu"]'), $courseType, $courseRank, $category, $order);
					if(!$slug) {
						$errors[] = "Une erreur est survenue lors de la création du document...";
					} elseif($extension) {
						$config['upload_path'] = './uploads/nexus/images/';
						$config['allowed_types'] = 'jpg|png|jpeg';
						$config['max_size'] = 2048;
						$config['file_name'] = $slug . '_img';

						$this->load->library('upload', $config);
						if($extension && !$this->upload->do_upload('userfile')) {
							$data['upload_errors'] = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
						}
					}
				} catch(Exception $e) {
					redirect('/error');
				}

				if(empty($data['upload_errors'])) {
					redirect('/nexus/' . $slug);
				}
			} else {
				$data['errors'] = $errors;
			}
		}

		$data['categories'] = $this->Nexus_model->getCategories();

		$this->load->view("templates/header", $data);
		$this->load->view("nexus/create", $data);
		$this->load->view("templates/footer");
	}

	public function edit($slug) {
		$this->lang->load('nexus', $this->session->lang);
		$data['page'] = (object) [
			'title' => "Editer document - Nexus - Royaume de Nelva",
			'description' => "Editer un nouveau document - Royaume de Nelva",
			'links' => [
				base_url() . 'assets/library/fileinput/css/fileinput.min.css'
			],
			'scripts' => [
				'https://cdn.ckeditor.com/4.6.2/full/ckeditor.js',
				base_url() . 'assets/library/atwho/atwho.min.js',
				base_url() . 'assets/library/fileinput/js/plugins/piexif.min.js',
				base_url() . 'assets/library/fileinput/js/fileinput.min.js',
				base_url() . 'assets/js/create_document.js'
			]
		];
		$document = $this->Nexus_model->get($slug);
		$data['document'] = $document;

		if(!$this->session->logged) {
			$data['authUrl'] = $this->getAuthUrl();
		}

		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$content = $this->input->post('content');
		$extension = $this->input->post('extension');
		$courseType = $this->input->post('courseType');
		$courseRank = $this->input->post('courseRank');
		$category = $this->input->post('category');
		$order = $this->input->post('courseOrder');

		if($title) {

			$errors = array();

			if(!$this->session->logged || !$this->session->isMember) {
				$errors[] = "Vous n'êtes pas autorisés à créer un document.";
			}

			if($document->author != $this->session->id && !$this->session->isAdmin) {
				$errors[] = "Vous ne pouvez pas modifier un document que vous n'avez pas créer.";
			}

			$title_length = strlen($title);
			if($title_length < 5 || $title_length > 60) {
				$errors[] = "Titre trop court ou trop long (5 < titre > 60).";
			}

			if($description && strlen($description) > 100) {
				$errors[] = "Description trop longue (max 100 caractères).";
			}

			if(!$content || strlen($content) < 5) {
				$errors[] = "Contenu vide ou trop court.";
			}

			if(!$this->session->logged) {
				$errors[] = "Vous n'êtes pas autorisés à créer un document.";
			}

			if(empty($errors)) {
				try {
					$newSlug = $this->Nexus_model->edit($slug, $title, $description, $content, $extension, $document->image, ($category == '["coursjeu"]'), $courseType, $courseRank, $category, $order);
					if(!$newSlug) {
						$errors[] = "Une erreur est survenue lors de la création du document...";
					} elseif($extension) {
						$config['upload_path'] = './uploads/nexus/images/';
						$config['allowed_types'] = 'jpg|png|jpeg';
						$config['max_size'] = 2048;
						$config['file_name'] = $slug . '_img';

						$this->load->library('upload', $config);
						if($extension && !$this->upload->do_upload('userfile')) {
							$data['upload_errors'] = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
						}
					}
				} catch(Exception $e) {
					redirect('/error');
				}

				if(empty($data['upload_errors'])) {
					redirect('/nexus/' . $newSlug);
				}
			} else {
				$data['errors'] = $errors;
			}
		}

		$data['categories'] = $this->Nexus_model->getCategories();

		$this->load->view("templates/header", $data);
		$this->load->view("nexus/edit", $data);
		$this->load->view("templates/footer");
	}

	public function delete($slug) {
		if($this->session->logged) {
			if($this->session->isAdmin) {
				$this->Nexus_model->delete($slug);
			} else {
				redirect('/error');
			}
		}
	}

	public function getCourseNames() {
		echo json_encode($this->Nexus_model->getCoursesNames($this->input->post('category')));
	}
}
