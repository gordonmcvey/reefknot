<?php
/**
 * PHPUnit boot strap file
 *
 * @author Gordon McVey
 */

require (realpath (__DIR__ . '/../bootstrap.php'));
require (realpath (__DIR__ . '/../vendor/autoload.php'));

use \gordian\reefknot as rf;

new rf\autoload\Autoloader (rf\PATH_FW, rf\NS_FW);
