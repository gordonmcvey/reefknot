<?php

/**
 * @author gordonmcvey
 */

require (realpath (__DIR__ . '/../bootstrap.php'));

// Storing the autoloader to a var lets us turn it off for unit testing the autoloader
$unitTestAutoloader	= new gordian\reefknot\autoload\Autoloader ();
