<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nexus_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->library('Helper');
		require_once('./vendor/autoload.php');
	}

	public function get($slug) {
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('slug', $slug);
		$result = $this->db->get()->result();

		if(is_array($result) && count($result) == 1) {
			$result = $result[0];
			$result->created_at = $this->helper->date($result->created_at);
			$result->edited_at = $this->helper->date($result->edited_at);
			return $result;
		}
		return null;
	}

	public function create($title, $description, $content, $img_ext, $course, $courseType, $courseRank, $tags, $order) {
		$i = 1;
		$slug = $this->url_title($title);
		while($this->get($slug) !== null) {
			$slug = $slug . '-' . $i;
			$i++;
		}
		$image = "";
		if($img_ext) {
			$image = $slug . '_img' . $img_ext;
		} else {
			$image = "default.png";
		}

		if($order) {
			$d = $this->get($order);
			if($d) {
				$order = intval($d->orderr) + 1;

				$this->db->set('orderr', 'orderr - 1', FALSE);
				$this->db->where('slug', $d->slug);
				$this->db->update('documents');

				$this->db->set('orderr', 'orderr + 1', FALSE);
				$this->db->where('orderr >= ', $d->orderr);
				$this->db->update('documents');
			}
		} else {
			$order = 0;
		}

		date_default_timezone_set("Europe/Paris");
		$document = array(
			'title' => $title,
			'content' => $content,
			'description' => $description,
			'slug' => $slug,
			'objectID' => $slug,
			'image' => $image,
			'author' => $this->session->user->id,
			'last_edited_by' => null,
			'created_at'  => date('Y-m-d H:i:s'),
			'edited_at'     => null,
			'required_access' => 0,
			'course' => ($course != null),
			'courseType' => ($course != null) ? $courseType : null,
			'courseRank' => ($course != null) ? $courseRank : null,
			'tags' => $tags,
			'orderr' => $order
		);

		$response = $this->db->insert('documents', $document);
		return ($response) ? $slug : false;
	}

	public function edit($oldSlug, $title, $description, $content, $img_ext, $image, $course, $courseType, $courseRank, $tags, $order) {
		$i = 1;
		$doc = $this->get($oldSlug);
		$slug = $this->url_title($title);
		if($slug != $oldSlug) {
			while($this->get($slug) !== null) {
				$slug = $slug . '-' . $i;
				$i++;
			}
		}

		if($order) {
			$d = $this->get($order);
			if($d) {
				$order = intval($d->orderr) + 1;

				$this->db->set('orderr', 'orderr - 1', FALSE);
				$this->db->where('slug', $d->slug);
				$this->db->update('documents');

				$this->db->set('orderr', 'orderr + 1', FALSE);
				$this->db->where('orderr >= ', $d->orderr);
				$this->db->update('documents');
			}
		} else {
			$order = $doc->orderr;
		}

		if(strlen($img_ext) > 0) {
			$image = $slug . '_img' . $img_ext;
			if(strlen($doc->image) > 0 && $doc->image != "default.png") {
				unlink('./uploads/nexus/images/' . $document->image);
			}
		} elseif(strlen($image) == 0) {
			if(strlen($doc->image) > 0 && $doc->image != "default.png") {
				unlink('./uploads/nexus/images/' . $document->image);
			}
			$image = "default";
			$img_ext = ".png";
		}

		date_default_timezone_set("Europe/Paris");
		$this->db->query("UPDATE documents SET title = ?, description = ?, content = ?, required_access = 0, image = ?, last_edited_by = ?, edited_at = NOW(), slug = ?, course = ?, courseType = ?, courseRank = ?, tags = ?, orderr = ? WHERE slug = ?",
		array($title, $description, $content, $image, $this->session->id, $slug, ($course != null), ($course != null) ? $courseType : null, ($course != null) ? $courseRank : null, $tags, $order, $oldSlug));

		return $slug;
	}

	public function getAll() {
		$this->db->select('*');
		$this->db->from('documents');
		return $this->db->get()->result_array();
	}

	public function delete($slug) {
		$document = $this->get($slug);
		if(strlen($document->image) > 0 && $document->image != "default.png") {
			unlink('./uploads/nexus/images/' . $document->image);
		}
		$this->db->where('slug', $slug);
		$this->db->delete('documents');
	}

	public function getCategories() {
		$this->db->select('*');
		$this->db->from('documents_categories');
		return $this->db->get()->result_array();
	}

	public function getCourses($type) {
		$this->db->select('*');
		$this->db->where('course', 1);
		$this->db->where('courseType', $type);
		$this->db->from('documents');
		$this->db->order_by('orderr', 'ASC');
		return $this->db->get()->result_array();
	}

	public function getCoursesNames($category) {
		$this->db->select('title');
		$this->db->select('slug');
		$this->db->where('course', 1);
		$this->db->where('courseType', $category);
		$this->db->from('documents');
		return $this->db->get()->result_array();
	}

	public function createTag($tag) {
		$this->db->insert('documents_categories', array(
			'tag' => $tag
		));
	}

	public function deleteTag($tag) {
		$this->db->where('tag', $tag);
		$this->db->delete('documents_categories');
	}

	public function url_title($str) {
		$str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
		$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
		$str = preg_replace('#&[^;]+;#', '', $str);
		$str = preg_replace('/ /', '-', $str);
		$str = preg_replace('/"/', '', $str);
		$str = preg_replace('/\'/', '', $str);
		$str = preg_replace('/=/', '', $str);
		$str = preg_replace('/,/', '', $str);
		$str = preg_replace('/\$/', '', $str);
		$str = preg_replace('/\+/', '', $str);
		$str = preg_replace('/\./', '', $str);
		$str = preg_replace('/%/', '', $str);
		$str = preg_replace('/\*/', '', $str);
		$str = preg_replace('/\//', '', $str);
		$str = preg_replace('/\)/', '', $str);
		$str = preg_replace('/\(/', '', $str);
		$str = preg_replace('/#/', '', $str);
		$str = preg_replace('/{/', '', $str);
		$str = preg_replace('/`/', '', $str);
		$str = preg_replace('/\\\/', '', $str);
		$str = preg_replace('/@/', '', $str);
		$str = preg_replace('/\^/', '', $str);
		$str = preg_replace('/&/', '', $str);
		$str = preg_replace('/}/', '', $str);
		$str = preg_replace('/:/', '', $str);
		$str = preg_replace('/;/', '', $str);
		return $str;
	}
}
