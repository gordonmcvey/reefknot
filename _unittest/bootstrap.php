<?php

/**
 * @author gordonmcvey
 */


/* 
 * The following is necessary to make testing the Session class possible.  I 
 * tried @outputBuffering enabled on the test class, but it didn't seem to help.
 * 
 * I'm still looking for a better solution to this particular problem.  Any
 * suggestions are more than welcome. 
 */
ob_start ();

require (realpath (__DIR__ . '/../bootstrap.php'));

// Storing the autoloader to a var lets us turn it off for unit testing the autoloader
$unitTestAutoloader	= new gordian\reefknot\autoload\Autoloader ();

