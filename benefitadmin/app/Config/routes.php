<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
 	/** FRONT **/


    Router::connect('/wecontrol/uploadUserAvatar', array('plugin' => 'wecontrol', 'controller' => 'admins','action' => 'uploadUserAvatar'));
 	Router::connect('/', array('plugin' => 'wecontrol', 'controller' => 'admins','action' => 'login'));

 	/** WECONTROL **/
 	Router::connect('/logout', array('controller' => 'admins', 'action' => 'logout'));
 	Router::connect('/wecontrol', array('plugin' => 'wecontrol', 'controller' => 'admins','action' => 'login'));
 	Router::connect('/wecontrol/dashboard/*', array('plugin' => 'wecontrol', 'controller' => 'dashboard'));
 	Router::connect('/wecontrol/change-password/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'change_password'));
 	Router::connect('/wecontrol/edit-profile/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'edit_profile'));
 	Router::connect('/wecontrol/login/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'login'));
 	Router::connect('/wecontrol/logout/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'logout'));


 	/** Categories **/
 	Router::connect('/wecontrol/categories/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'categories'));
 	Router::connect('/wecontrol/add-category/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'add_category'));
 	Router::connect('/wecontrol/edit-categry/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'edit_category'));

 	/** states **/
 	Router::connect('/wecontrol/states/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'states'));
 	Router::connect('/wecontrol/add-state/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'add_state'));
 	Router::connect('/wecontrol/edit-state/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'edit_state'));


 	/** Cities **/

 	Router::connect('/wecontrol/cities/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'cities'));
 	Router::connect('/wecontrol/add-city/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'add_city'));
 	Router::connect('/wecontrol/edit-city/*', array('plugin' => 'wecontrol', 'controller' => 'masters', 'action' => 'edit_city	'));

 	/*Analyst*/
 	Router::connect('/wecontrol/analysts/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'analysts'));
 	Router::connect('/wecontrol/add-analyst/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'add_analyst'));
 	Router::connect('/wecontrol/edit-analyst/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'edit_analyst'));
 	Router::connect('/wecontrol/view-analyst/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'view_analyst'));

 	/*Article*/
 	Router::connect('/wecontrol/articles/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'articles'));
 	Router::connect('/wecontrol/add-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'add_article'));
 	Router::connect('/wecontrol/edit-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'edit_article'));
 	Router::connect('/wecontrol/view-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'view_article'));

 	/*Pending request*/
 	Router::connect('/wecontrol/articles/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'articles'));
 	Router::connect('/wecontrol/add-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'add_article'));
 	Router::connect('/wecontrol/edit-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'edit_article'));
 	Router::connect('/wecontrol/view-article/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'view_article'));

 	/*Client*/
 	Router::connect('/wecontrol/pending-request/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'pending_analysts'));
 	Router::connect('/wecontrol/view-pending-request/*', array('plugin' => 'wecontrol', 'controller' => 'users', 'action' => 'view_pending_analyst'));

 		/*Admins*/

 	Router::connect('/wecontrol/admin/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'index'));
 	Router::connect('/wecontrol/add/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'add'));
 	Router::connect('/wecontrol/edit/*', array('plugin' => 'wecontrol', 'controller' => 'admins', 'action' => 'edit'));


 	CakePlugin::routes();
/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';