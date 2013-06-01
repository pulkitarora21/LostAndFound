<?php

/**
 * File containing all the routes.
 *
 * This file is containing all of the valid routes for the application. E.g. If the url entered is ended with
 * /home than the control will go to homeController -> index(). If an invalid route is entered (not listed in the
 * list), an error will occur.
 * Purposes of this file:
 * 1. sanitise (remove magic quotes, slashes, global vars)
 * 2. do the routing - convert path into controller and action
 * 3. autoload objects
 * 4. error level/reporting
 *
 * @package config
 */

/**
 * Defining a constant that is pointing to libraries directory.
 */
define( 'LIBRARY_PATH', APP_PATH . DS . 'libraries' );

$routes = array();
$routes['#^/$#i'] = array( 'controller' => 'home', 'action' => 'index' );
$routes['#^/home$#i'] = array( 'controller' => 'home', 'action' => 'index' );
$routes['#^/home/index$#i'] = array( 'controller' => 'home', 'action' => 'index' );

$routes['#^/error$#i'] = array( 'controller' => 'error', 'action' => 'error' );

$routes['#^/users$#i'] = array( 'controller' => 'users', 'action' => 'index' );
$routes['#^/users/new$#i'] = array( 'controller' => 'users', 'action' => 'add' );
$routes['#^/users/create$#i'] = array( 'controller' => 'users', 'action' => 'create' );
$routes['#^/users/activate/([0-9a-z]{50})$#i'] = array( 'controller' => 'users', 'action' => 'activate' );
$routes['#^/users/forgot_password$#i'] = array( 'controller' => 'users', 'action' => 'forget' );
$routes['#^/users/forgot_password/retrieve$#i'] = array( 'controller' => 'users', 'action' => 'generate' );
$routes['#^/users/change_password$#i'] = array( 'controller' => 'users', 'action' => 'change' );
$routes['#^/users/change_password/modify$#i'] = array( 'controller' => 'users', 'action' => 'modify' );
$routes['#^/users/showMyItem$#i'] = array( 'controller' => 'users', 'action' => 'show' );
$routes['#^/users/showMyItem/deleteLost$#i'] = array( 'controller' => 'users', 'action' => 'deleteLost' );
$routes['#^/users/showMyItem/deleteFound$#i'] = array( 'controller' => 'users', 'action' => 'deleteFound' );

$routes['#^/users/edit$#i'] = array( 'controller' => 'users', 'action' => 'edit' );
$routes['#^/users/update$#i'] = array( 'controller' => 'users', 'action' => 'update' );
$routes['#^users/filter$#i'] = array( 'controller' => 'users', 'action' => 'filter' );

$routes['#^/session/new$#i'] = array( 'controller' => 'session', 'action' => 'add' );
$routes['#^/session/create$#i'] = array( 'controller' => 'session', 'action' => 'create' );
$routes['#^/session/destroy$#i'] = array( 'controller' => 'session', 'action' => 'destroy' );

$routes['#^/post$#i'] = array( 'controller' => 'post', 'action' => 'post' );
$routes['#^/postItem#i'] = array( 'controller' => 'post', 'action' => 'postItem' );

$routes['#^/found$#i'] = array( 'controller' => 'found', 'action' => 'index' );
$routes['#^/found/([0-9]{1,5})$#i'] = array( 'controller' => 'found', 'action' => 'show' );
$routes['#^/found/match$#i'] = array( 'controller' => 'found', 'action' => 'match' );

$routes['#^/lost$#i'] = array( 'controller' => 'lost', 'action' => 'index' );
$routes['#^/lost/([0-9]{1,5})$#i'] = array( 'controller' => 'lost', 'action' => 'show' );

$routes['#^/search$#i'] = array( 'controller' => 'search', 'action' => 'index' );
$routes['#^/normalSearch$#i'] = array( 'controller' => 'search', 'action' => 'get' );
$routes['#^/advancedSearch$#i'] = array( 'controller' => 'search', 'action' => 'obtain' );

$routes['#^/admin/listUsers$#i'] = array( 'controller' => 'admin', 'action' => 'listUsers' );
$routes['#^/admin/editUser$#i'] = array( 'controller' => 'admin', 'action' => 'editUser' );
$routes['#^/admin/blockUser$#i'] = array( 'controller' => 'admin', 'action' => 'blockUser' );
$routes['#^/admin/unblockUser$#i'] = array( 'controller' => 'admin', 'action' => 'unblockUser' );


$routes['#^/privacy$#i'] = array( 'controller' => 'home', 'action' => 'privacy' );
$routes['#^/aboutus$#i'] = array( 'controller' => 'home', 'action' => 'aboutus' );
$routes['#^/contactus$#i'] = array( 'controller' => 'home', 'action' => 'contactus' );
$routes['#^/sitemap$#i'] = array( 'controller' => 'home', 'action' => 'sitemap' );
