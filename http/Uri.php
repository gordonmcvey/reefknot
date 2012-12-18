<?php
/**
 * Reefknot framework
 * 
 * @copyright Gordian Solutions and Gordon McVey
 * @license http://www.apache.org/licenses/LICENSE-2.0.txt Apache license V2.0
 */

namespace \gordian\reefknot\http;

/**
 * Description of Uri
 *
 * @author gordonmcvey
 */
class Uri implements iface\Uri
{
	private
		$constructerUri	= NULL,
		$uri			= NULL,
		$scheme			= 'http',
		$host			= '',
		$port			= 80,
		$user			= '',
		$password		= '',
		$path			= '/',
		$query			= '',
		$fragment		= '';
	
	public function __construct ($uri)
	{
		if (is_string ($uri))
		{
			$uri	= parse_url ($uri);
		}
		
		if ((!is_array ($uri))
		|| (!$this -> storeUri ($uri)))
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
	}

	public function __toString ()
	{
		return $this -> getUri ();
	}
	
	/**
	 * Get the URI string
	 * 
	 * @return string
	 */
	public function getUri ()
	{
		if (NULL === $this -> uri)
		{
			$this -> uri	= $this -> getScheme ()
							. '://'
							. ($user = $this -> getCredentialString ()? $user . '@': '')
							. $this -> getHost ()
							. (($port = $this -> getPort () !== 80)? ':' . $port: '')
							. $this -> getPath ()
							. ($query = $this -> getQueryString ()? '?' . $query: '')
							. ($frag = $this -> getFragment ()? '#' . $frag: '');
		}
		
		return $this -> uri;
	}
	
	/**
	 * Get formatted username/password pair
	 * 
	 * @return string
	 */
	private function getCredentialString ()
	{
		$str	= $this -> getUser ();
		
		// A username without a password is valid, but the reverse isn't
		if ((!empty ($str))
		&& ($pw = $this -> getPassword ()))
		{
			$str	.= ':' . $pw;
		}
		return $str;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFragment ()
	{
		return $this -> fragment;
	}

	/**
	 * 
	 * @return string
	 */
	public function getHost ()
	{
		return $this -> host;
	}

	/**
	 * 
	 * @return string
	 */
	public function getPassword ()
	{
		return str_repeat ('*', strle ($this -> password));
	}

	/**
	 * 
	 * @return string
	 */
	public function getPath ()
	{
		return $this -> path;
	}

	/**
	 * 
	 * @return int
	 */
	public function getPort ()
	{
		return $this -> port;
	}

	/**
	 * 
	 * @return string
	 */
	public function getQueryString ()
	{
		return $this -> query;
	}

	/**
	 * 
	 * @return string
	 */
	public function getRawPassword ()
	{
		return $this -> password;
	}

	/**
	 * 
	 * @return string
	 */
	public function getScheme ()
	{
		return $this -> scheme;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getUser ()
	{
		return $this -> user;
	}
	
	/**
	 * 
	 * @param string $scheme
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setScheme ($scheme)
	{
		if (($scheme === 'http')
		|| ($scheme === 'https'))
		{
			$this -> scheme	= $scheme;
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $host
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setHost ($host)
	{
		if (is_string ($host))
		{
			$this -> host	= $host;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param int $port
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setPort ($port)
	{
		if (is_int ($port))
		{
			$this -> port	= $port;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $password
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setPassword ($password)
	{
		if (is_string ($password))
		{
			$this -> password	= $password;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $path
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setPath ($path)
	{
		if (is_string ($path))
		{
			$this -> path	= $path;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param string|array $query
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setQuery ($query)
	{
		if (is_array ($query))
		{
			$query	= http_build_query ($query);
		}
		
		if (is_string ($query))
		{
			$this -> query	= $query;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $fragment
	 * @return \Uri
	 * @throws \InvalidArgumentException
	 */
	public function setFragment	($fragment)
	{
		if (is_string ($fragment))
		{
			$this -> fragment	= $fragment;
			$this -> resetUri ();
		}
		else
		{
			throw new \InvalidArgumentException (__METHOD__);
		}
		
		return $this;
	}
	
	/**
	 * 
	 */
	private function resetUri ()
	{
		$this -> uri	= NULL;
	}
	
	/**
	 * Store the URL to the object's properties
	 * 
	 * @param array $uriData
	 * @return boolean
	 */
	private function storeUri (array $uriData)
	{
		$success	= false;
		
		// Check we have the minimum data needed to store the URI
		if ((isset ($uriData ['scheme']))
		&& (isset ($uriData ['host'])))
		{
			$success	= true;
			$this -> setScheme ($uriData ['scheme']);
			$this -> setHost ($uriData ['host']);
			
			if (isset ($uriData ['port']))
			{
				$this -> setPort ($uriData ['port']);
			}
			
			if (isset ($uriData ['user']))
			{
				$this -> setUser ($uriData ['user']);
			}
			
			if (isset ($uriData ['pass']))
			{
				$this -> setPassword ($uriData ['pass']);
			}
			
			if (isset ($uriData ['path']))
			{
				$this -> setPath ($uriData ['path']);
			}
			
			if (isset ($uriData ['query']))
			{
				$this -> setQuery ($uriData ['query']);
			}
			
			if (isset ($uriData ['fragment']))
			{
				$this -> setFragment ($uriData ['fragment']);
			}
		}
		
		return $success;
	}
}
