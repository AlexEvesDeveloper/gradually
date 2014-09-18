<?php

namespace Gradually\LibraryBundle\Classes\Doctrine;

/**
 * Representation of the MySQL data type POINT.
 */
class Point
{
	private $longitude;
	private $latitude;

	public function __construct($longitude, $latitude)
	{
		$this->longitude = $longitude;
		$this->latitude = $latitude;
	}

	public function setLatiude($x)
	{
		$this->latitude = $x;
	}

	public function setLongitude($y)
	{
		$this->longitude = $y;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}

	public function __toString()
	{
		//Output from this is used with POINT_STR in DQL so must be in specific format
        return sprintf('POINT(%f %f)', $this->latitude, $this->longitude);
	}
}