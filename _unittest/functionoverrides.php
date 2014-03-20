<?php

/**
 * Function override file
 * 
 * This file exists solely to override specific functions during specific tests
 * within specific namespaces to allow testing to proceed.  For example, tests
 * that rely on VFSStream for filesystem mocking will fail if you try to use
 * a lock because VFSStream doesn't support them.  Other filesystem functions
 * don't work with stream wrappers (for example, realpath).  
 * 
 * Hopefully future versions of PHP will let us handle issues such as this more
 * elegantly.  In the meantime, enjoy the horrible, evil hacky kludge, folks!
 */

namespace gordian\reefknot\autoload\classmap {
	
	/**
	 * Override file_put_contents to ignore file locking because it doesn't work 
	 * with vfsstream
	 */
	function file_put_contents ($filename, $data, $flags = 0, $context = NULL) {
		return \file_put_contents ($filename, $data, 0, $context);
	}
}
namespace gordian\reefknot\autoload\classmap\abstr {

	/**
	 * Override file_put_contents to ignore file locking because it doesn't work 
	 * with vfsstream
	 */
	function file_put_contents ($filename, $data, $flags = 0, $context = NULL) {
		return \file_put_contents ($filename, $data, 0, $context);
	}
}
