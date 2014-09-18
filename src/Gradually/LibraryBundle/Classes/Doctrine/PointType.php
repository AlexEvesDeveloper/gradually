<?php

namespace Gradually\LibraryBundle\Classes\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Extend Doctrine to create a new data type, POINT.
 */
class PointType extends Type
{
	const POINT = 'point';

	// abstract method from parent
	public function getName()
	{
		return self::POINT;
	}

	// abstract method from parent
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $Platform)
	{
		return 'POINT';
	}

	public function convertToPHPValue($value, AbstractPlatform $Platform)
	{
		// Null fields come into this function as empty strings
		if($value == ''){
			return null;
		}

		$data = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $value);
		return new Point($data['lat'], $data['lon']);
	}

	public function convertToDatabaseValue($value, AbstractPlatform $Platform)
	{
		if(!$value){
			return;
		}

		return pack('xxxxcLdd', '0', 1, $value->getLatitude(), $value->getLongitude());
	}
}