<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends MY_Model {
	private $discord;

	public function __construct() {
		$this->load->database();
		require_once('./vendor/autoload.php');
		$this->discord = new RestCord\DiscordClient(['token' => ""]);

	}

	public function getBest($user) {
		$this->db->select('id, pseudo, message, author, date');
		$this->db->from('bestiaire');
		$this->db->where('pseudo', $user);
		$uDB = $this->db->get()->result();
		return $uDB;
	}

	public function deleteBestiaire($id) {
		$this->db->where('id', $id);
		$this->db->delete('bestiaire');
	}

	public function sendNotify($role, $message) {
		$this->discord->channel->createMessage([
			'channel.id' => intval(354658262848634880),
			'content' => '/notify <@&' . $role . '>' . ' -message=' . $message
		]);
	}

	public function addBestiaire($pseudo, $message, $username) {
		date_default_timezone_set("Europe/Paris");
		$date = new DateTime('now');
		$this->db->insert('bestiaire', [
			'pseudo' => $pseudo,
			'message' => $message,
			'author' => $username,
			'date' => $date->format('d/m/Y')
		]);
	}

	public function getBestiaire() {
		$this->db->distinct();
		$this->db->select('pseudo');
		$this->db->from('bestiaire');
		$users = $this->db->get()->result();

		$output = [];
		foreach($users as $u) {
			$this->db->select('id, pseudo, message, author, date');
			$this->db->from('bestiaire');
			$this->db->where('pseudo', $u->pseudo);
			$uDB = $this->db->get()->result();
			$user = [];
			foreach($uDB as $ud) {
				$user[] = $ud;
			}
			$output[] = $user;
		}
		return $output;
	}

	public function getDiscordStats($period) {
		$this->db->select('date');
		$this->db->select_sum('m_count');
		$this->db->from('discord_stats');
		$this->db->group_by('date');

		if($period) {
			$period = explode(' - ', $period);

			$period[0] = substr($period[0], 6, 4) . '-' . substr($period[0], 3, 2) . "-" . substr($period[0], 0, 2);
			$period[1] = substr($period[1], 6, 4) . '-' . substr($period[1], 3, 2) . "-" . substr($period[1], 0, 2);

			$this->db->where("date >= ", $period[0]);
			$this->db->where("date <= ", $period[1]);
		}

		$stats = $this->db->get()->result();
		return $stats;
	}

	public function avatar_format($avatar, $id) {
		if($avatar) {
			return 'https://cdn.discordapp.com/avatars/' . $id . '/' . $avatar;
		}
		else {
			return [ 'https://discordapp.com/assets/1cbd08c76f8af6dddce02c5138971129.png',
			'https://discordapp.com/assets/6debd47ed13483642cf09e832ed0bc1b.png',
			'https://discordapp.com/assets/dd4dbc0016779df1378e7812eabaa04d.png',
			'https://discordapp.com/assets/0e291f67c9274a1abdddeb3fd919cbaa.png'
			][rand(0,3)];
		}
	}

	public function roles_format($user, $serverRoles) {
		$roles = [];
		foreach($user->roles as $role) {
			foreach($serverRoles as $sRole) {
				if($role == $sRole->id && strrpos($sRole->name, "Rang") === FALSE) {
					$roles[] = $sRole;
				}
			}
		}
		$user->roles = $roles;
		return $user;
	}

	public function getRoles() {
		try {
			$roles = $this->discord->guild->getGuildRoles([
				'guild.id' => intval("281489896563277825")
			]);
			return $roles;
		} catch(Exception $error) {
			return false;
		}
	}

	public function getRank($user, $roles) {
		$rank = "Rang 5";
		foreach($user->roles as $role) {
			foreach($roles as $serverRole) {
				if($role == $serverRole->id && strrpos($serverRole->name, "Rang") !== FALSE) {
					$rank = $serverRole->name;
				}
			}
		}
		return $rank;
	}

	public function getMembers() {
		$data = (object) [
			'visitors' => [],
			'members' => [],
			'admins' => []
		];

		try {
			$guildMembers = $this->discord->guild->listGuildMembers([
				'guild.id' => intval("281489896563277825"),
				'limit' => 1000
			]);
			$roles = $this->getRoles();
			foreach($guildMembers as $user) {
				if(array_search(intval(281529716303986688), $user->roles) !== false) {
					$data->admins[] = $user;
				} elseif(array_search(intval(281540700556754944), $user->roles) !== false) {
					$data->members[] = $user;
				} else {
					$data->visitors[] = $user;
				}

				/* To be modified */

				$this->db->select('AVG(m_count) as average');
				$this->db->from('discord_stats');
				$this->db->where('user_id', $user->user->id);
				$this->db->where('DATEDIFF(CURDATE(), date) < 31');
				$activity = $this->db->get()->result();

				$user->activity = (is_array($activity) && count($activity) > 0 && $activity[0]->average) ? round($activity[0]->average) : 0;
				if($user->activity > 100) {
					$user->activity = 100;
				}

				$user->rank = $this->getRank($user, $roles);
				$user = $this->roles_format($user, $roles);

				$i = 0;
				$user->formatted_roles = "";
				for($i = 0; $i < count($user->roles); $i++) {
					if($i == count($user->roles) - 1) {
						$user->formatted_roles .= $user->roles[$i]->name;
					} else {
						$user->formatted_roles .= $user->roles[$i]->name . ", ";
					}
				}

				$user->user->avatar = $this->avatar_format($user->user->avatar, $user->user->id);
			}
			return $data;
		} catch(Exception $e) { }
		return $data;
	}
}
