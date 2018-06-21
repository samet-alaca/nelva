<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
	/**
	* Format given date string
	* @param string $d
	* @return string
	*/
	public static function date($d) {
		date_default_timezone_set("Europe/Paris");
		$now = new DateTime('now');
		$date = new DateTime($d);
		$old = new DateTime($date->format('Y-m-d'));
		$diff = $old->diff($now)->days;
		switch($diff) {
			case 0:
			return "Aujourd'hui à " . $date->format('H\hi');
			break;
			case 1:
			return "Hier à " . $date->format('H\hi');
			break;
			default:
			return $date->format('d/m/Y à H\hi');
		}
	}

	/**
	* Return $text with 's' at the end if $count > 1
	* @param string $str
	* @return string
	*/
	private static function pluralize($count, $text)
	{
		return $count . (($count > 1) ? (" $text ") : (" ${text}s "));
	}

	/**
	* Format date by comparing to now
	* @param string $datetime
	* @return string
	*/
	public static function ago($datetime)
	{
		date_default_timezone_set("Europe/Paris");
		$interval = date_create('now')->diff(new DateTime($datetime));
		$prefix = ($interval->invert ? 'il y a ' : '');
		if ($v = $interval->y >= 1) return $prefix . self::pluralize($interval->y, 'an');
		if ($v = $interval->m >= 1) return $prefix . self::pluralize($interval->m, 'mois');
		if ($v = $interval->d >= 1) return $prefix . self::pluralize($interval->d, 'jour');
		if ($v = $interval->h >= 1) return $prefix . self::pluralize($interval->h, 'heure');
		if ($v = $interval->i >= 1) return $prefix . self::pluralize($interval->i, 'minute');
		return $prefix . self::pluralize( $interval->s, 'seconde');
	}

	/**
	* Returns random string with given length
	* @param int $length
	* @return string
	*/
	public function new_token($length) {
		return substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", $length)), 0, $length);
	}
}
