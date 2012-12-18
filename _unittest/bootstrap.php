<?php

/**
 * @author gordonmcvey
 */

require (realpath (__DIR__ . '/../bootstrap.php'));

$unitTestAutoloader		= new \gordian\reefknot\autoload\MappedAutoloader (\gordian\reefknot\PATH_FW, \gordian\reefknot\NS_FW);
