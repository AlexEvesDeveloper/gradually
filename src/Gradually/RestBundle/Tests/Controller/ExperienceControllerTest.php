<?php

namespace Gradually\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExperienceControllerTest extends WebTestCase
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
    		'company' => 'Reconnix',
    		'summary' => 'I was a PHP Developer',
    		'yearFrom' => 2010,
    		'yearTo' => 2012
    	));

    	$this->sendRequest('POST', 'api/graduates/17/experiences.json', $json);

    	$this->assertEquals($this->client->getResponse()->getStatusCode(), 201);
    }
}