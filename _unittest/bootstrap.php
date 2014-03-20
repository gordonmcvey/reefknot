<?php
/**
 * PHPUnit boot strap file
 *
 * @author Gordon McVey
 */

require (__DIR__ . '/../bootstrap.php');
require (__DIR__ . '/../vendor/autoload.php');
require (__DIR__ . '/functionoverrides.php');
use \gordian\reefknot as rf;

new rf\autoload\Autoloader (rf\PATH_FW, rf\NS_FW);
