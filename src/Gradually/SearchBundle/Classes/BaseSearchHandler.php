<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

abstract class BaseSearchHandler
{
	protected $queryString;
	protected $queryParams = array();
	protected $em;

	abstract protected function initQueryString();
	abstract protected function applyFilters(Form $form);

	/**
     * Constructor.
     *
     * Initialise database connection and inject services.
	 *
	 * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine.
     */
	public function __construct(EntityManager $em)
	{
		// initialise the query string specific for the concrete search class
		static::initQueryString();

		$this->em = $em;
	}

	/**
	 * Construct the query string.
	 */
	public function prepareQuery(Form $form, array $orderBy)
	{
		// apply parameters specific to the concrete search class
		static::applyFilters($form);
		$this->queryString = sprintf('%s ORDER BY %s %s', $this->queryString, $orderBy['property'], $orderBy['order']);
	}

	/**
	 * Get the query string.
	 *
	 * @return string.
	 */
	public function getQueryString()
	{
		return $this->queryString;
	}

	/**
	 * Get the query parameters.
	 *
	 * @return array.
	 */
	public function getQueryParameters()
	{
		return $this->queryParams;
	}	

	/**
	 * Returns the query string, with its parameters appended to the end, comma separated.
	 *
	 * It's not really encoded, but the imploded queryParams make it return a unique string for each 
	 * query.
	 *
	 * Primarily used by memcache to create a unique key for each specificly filtered query,
	 * But also good for debugging purposes.
	 */
	public function getEncodedQueryString()
	{
		return $this->queryString . implode(',', $this->queryParams);
	}
}
