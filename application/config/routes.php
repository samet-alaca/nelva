<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['postNotify'] = "admin/postNotify";
$route['stats'] = "admin/discordStats";
$route['bestiaire'] = "admin/getBestiaire";
$route['landing'] = "home/landing";
$route['admin'] = "admin/index";
$route['users'] = "user/users";
$route['users/wrap'] = "user/usersWrap";
$route['users/usernames'] = "user/usernames";
$route['users/(:any)'] = "user/user/$1";
$route['nexus/getCourseNames'] = "nexus/getCourseNames";
$route['academy/military'] = "academy/military";
$route['academy/diplomacy'] = "academy/diplomacy";
$route['academy/leadership'] = "academy/leadership";
$route['academy/economy'] = "academy/economy";
$route['academy/cours/(:any)'] = "academy/get/$1";
$route['academy'] = "academy/index";

$route['error'] = 'home/error';
$route['lang'] = 'home/lang';
$route['cinelva'] = 'home/cinelva';
$route['chronicles'] = 'home/chronicles';
$route['signin'] = 'user/signin';
$route['nexus/create'] = 'nexus/create';
$route['nexus/edit/(:any)'] = 'nexus/edit/$1';
$route['nexus/(:any)'] = 'nexus/get/$1';
$route['nexus'] = 'nexus';
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
