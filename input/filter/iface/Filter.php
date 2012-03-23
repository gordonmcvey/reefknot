<?php

namespace gordian\reefknot\input\filter\iface;

/**
 *
 * @author gordonmcvey
 */
interface Filter
{
	public function setData ($data);
	public function setConfig (array $config);
	public function getConfig ();
	public function filter ();
}
