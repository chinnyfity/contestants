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

//$route['default_controller'] = "welcome";
$route['default_controller'] = "node";

$route['404_override'] = '';

$route['pageants'] = 'node/pageants/';
$route['events'] = 'node/events/';
$route['replies/(:any)'] = 'node/replies/$1/';
$route['viewevents/(:any)'] = 'node/viewevents/$1/';
$route['viewprofile/(:any)'] = 'node/viewprofile/$1/$2';
$route['pages'] = 'node/pages/';
$route['stores/(:any)'] = 'node/stores/';
$route['stores'] = 'node/stores/';
$route['confirm'] = 'node/confirm/';
$route['success'] = 'node/success/';
$route['login'] = 'node/login/';
$route['contact'] = 'node/contact/';
$route['about'] = 'node/about/';
$route['participate'] = 'node/participate/';
$route['error'] = 'node/error/';
$route['update_profile'] = 'node/update_profile/';
$route['signin'] = 'node/signin/';
$route['signout'] = 'node/signout/';
$route['compatibility'] = 'node/compatibility/';

$route['(:num)'] = 'node/profile/';
$route['(:num)(:any)(:num)'] = 'node/products/';

$route['translate_uri_dashes'] = FALSE;



/* End of file routes.php */
/* Location: ./application/config/routes.php */
