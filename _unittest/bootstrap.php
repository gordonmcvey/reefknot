<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author gordonmcvey
 */
//ini_set('include_path', ini_get('include_path'));

// put your code here

// This must be in place, as the session class is unable to start the session once output has been sent
ob_start ();

require (realpath (__DIR__ . '/../bootstrap.php'));

// Storing the autoloader to a var lets us turn it off for unit testing the autoloader
$unitTestAutoloader	= new gordian\reefknot\autoload\Autoload ();
?>
