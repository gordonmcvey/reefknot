<?php

/**
 * PHPUnit boot strap file
 *
 * @author Gordon McVey
 */

require (realpath (__DIR__ . '/../bootstrap.php'));

use \gordian\reefknot as rf;

require	(rf\PATH_FW . rf\DS . 'autoload' . rf\DS . 'classmap' . rf\DS . 'ArrayClassMap.php');

$unitTestAutoloader = new rf\autoload\MappedAutoloader (rf\PATH_FW, rf\NS_FW);
$unitTestAutoloader -> setClassMap (new rf\autoload\classmap\ArrayClassMap ());
$unitTestAutoloader -> enableAutoPopulate ();

echo ("Bootstrapped\n");
