<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "base";
$route['404_override'] = '';

$route['(?i)prijava'] = 'auth/Login';
$route['(?i)odjava'] = 'auth/Logout';
$route['(?i)domov'] = 'home';
$route['(?i)ustvari/(:any)'] = 'content/Create/$1';
$route['(?i)kategorija/(:any)'] = 'home/View/$1';
$route['(?i)vsebina/(:num)/urejanje'] = 'content/Edit/$1';
$route['(?i)vsebina/(:num)/(:any)'] = 'content/Read/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */