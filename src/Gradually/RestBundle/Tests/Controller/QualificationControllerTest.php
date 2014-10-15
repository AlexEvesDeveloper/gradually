<?php

namespace Gradually\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QualificationControllerTest extends WebTestCase
{
	private $client;

    public function setUp()
    {
         $this->client = static::createClient();
    }

    private function sendRequest($method, $url, $json = null, $type = 'application/json')
    {
    	$this->client->request(
    		strtoupper($method),
    		$url,
    		array(),
    		array(),
    		array('CONTENT_TYPE' => $type),
    		$json
    	);
    }

    public function testPostAQualification()
    {
    	$json = json_encode(array(
    		'school' => 'Kineton High School',
    		'course' => 'Maths',
    		'courseLevel' => 'GCSE',
    		'grade' => 'A',
            'yearAttained' => 2000
    	));

    	$this->sendRequest('POST', 'api/graduates/17/qualifications.json', $json);

    	$this->assertEquals($this->client->getResponse()->getStatusCode(), 201);
    }
}