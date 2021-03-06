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

$route['default_controller'] = 'pages/view/home';
$route['404_override'] = '';

$route['signin'] = 'auth/signin';
$route['signout'] = 'auth/signout';

$route['wizard'] = "wizard/view/start";
$route['wizard/(:any)'] = "wizard/view/$1";

$route['dmp'] = "dmp";

$route['overview'] = "overview";
$route['overview/(:any)'] = "overview/$1";

$route['admin'] = "admin";
$route['admin/(:any)'] = "admin/$1";
$route['admin/page/add'] = "admin/add_page";
$route['admin/page_categories/order'] = "admin/order_page_categories";
$route['admin/category/add'] = "admin/add_category";

$route['profile'] = 'profile';

$route['projects'] = 'projects/my';
$route['projects/start'] = "projects/start";
$route['projects/create'] = "projects/create";
$route['project/(:any)/edit'] = "projects/edit/$1";
$route['project/(:any)/create_ckan_group'] = "projects/create_ckan_group/$1";
$route['project/(:any)/refresh_datasets'] = "projects/refresh_datasets/$1";
$route['project/(:any)/delete'] = "projects/delete/$1";
$route['project/(:any)/archive'] = "projects/archive/$1";
$route['project/(:any)'] = "projects/project/$1";
$route['dataset/(:any)/deposit'] = "datasets/deposit_to_eprints/$1";

$route['test'] = 'test';

// Magic redirections!

$route['project/c014fb3845e7b054/public'] = 'redirect/dataset/library-activity-data';

$route['(:any)'] = "pages/view/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */