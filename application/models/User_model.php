<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
	private $discord;

	public function __construct() {
		$this->load->database();
		require_once('./vendor/autoload.php');
		$this->discord = new RestCord\DiscordClient(['token' => ""]);
	}

	public function avatar_format($avatar, $id) {
		if($avatar) {
			return 'https://cdn.discordapp.com/avatars/' . $id . '/' . $avatar;
		}
		else {
			return [
				'https://discordapp.com/assets/1cbd08c76f8af6dddce02c5138971129.png',
				'https://discordapp.com/assets/6debd47ed13483642cf09e832ed0bc1b.png',
				'https://discordapp.com/assets/dd4dbc0016779df1378e7812eabaa04d.png',
				'https://discordapp.com/assets/0e291f67c9274a1abdddeb3fd919cbaa.png'
			][rand(0,3)];
		}
	}

	public function get($id) {
		try {
			$user = $this->discord->guild->getGuildMember([
				'guild.id' => intval("281489896563277825"),
				'user.id' => intval($id),
			]);
			$user->user->avatar = $this->avatar_format($user->user->avatar, $user->user->id);
			return $user;
		} catch(Exception $error) {
			return false;
		}
	}

	public function getRank($id) {
		$this->db->select('*');
		$this->db->from('rangs');
		$this->db->where('id', $id);
		$rank = $this->db->get()->result();
		return (is_array($rank) && count($rank) > 0) ? $rank[0] : false;
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

	public function getDiscordStats($user, $period = null) {
		$this->db->from('discord_stats');
		$this->db->join('discord_users', 'user = user_id');
		$this->db->where('user', $user);

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

	public function signin($code) {
		if($code) {
			$provider = new \Wohali\OAuth2\Client\Provider\Discord([
				'clientId' => '282165070706900992',
				'clientSecret' => 'AqUJPyIfY8JKkdBmITKLs36kREeixueB',
				'redirectUri' => $this->getRedirectUri()
			]);

			$token = $provider->getAccessToken('authorization_code', [
				'code' => $code
			]);

			try {
				$user = $provider->getResourceOwner($token);
				$this->session->user = (object) $user->toArray();
			} catch(Exception $e) {
				return false;
			}

			try {
				$guildMember = $this->discord->guild->getGuildMember([
					'guild.id' => intval(281489896563277825),
					'user.id' => intval($this->session->user->id)
				]);
				$this->session->isMember = true;
				$this->session->isAdmin = (array_search(intval(281529716303986688), $guildMember->roles) !== false);
			} catch (Exception $e) {
				$this->session->isMember = false;
				$this->session->isAdmin = false;
			}
			return true;
		}
		return false;
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

			foreach($guildMembers as $user) {
				if(array_search(intval(319163611681390604), $user->roles) !== false) {
					$data->visitors[] = $user;
				} elseif(array_search(intval(281529716303986688), $user->roles) !== false) {
					$data->admins[] = $user;
				} elseif(array_search(intval(281540700556754944), $user->roles) !== false) {
					$data->members[] = $user;
				}

				$user->user->avatar = $this->avatar_format($user->user->avatar, $user->user->id);
			}
			return $data;
		} catch(Exception $e) { }
		return $data;
	}
}
