<?php

namespace Gradually\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
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

    public function testPostAJob()
    {
    	$json = json_encode(array(
    		'title' => 'Account Manager',
    		'description' => 'Manage the accounts',
    		'salaryFrom' => 28000,
    		'salaryTo' => 30000
    	));

    	$this->sendRequest('POST', 'api/recruiters/75/jobs.json', $json);

    	print_r($this->client->getResponse()->getContent());

    	$this->assertEquals($this->client->getResponse()->getStatusCode(), 201);
    }
}