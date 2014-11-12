<?php

namespace Gradually\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecruiterControllerTest extends WebTestCase
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

    public function testPostAGraduate()
    {
    	$json = json_encode(array(
    		'firstName' => 'Tom',
    		'lastName' => 'Jones',
    		'email' => 'tom3@test.com',
    		'password' => 'fsdfpassword'
    	));

    	$this->sendRequest('POST', 'api/recruiters.json', $json);

    	print_r($this->client->getResponse()->getContent());

    	$this->assertEquals($this->client->getResponse()->getStatusCode(), 201);
    }
}