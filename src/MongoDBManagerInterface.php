<?php
declare(strict_types=1);


namespace MongoDBInjector;

use MongoDB\Client;
use MongoDB\Database;
use ReflectionClass;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Core\Container\InjectorInterface;
use Spiral\Core\Container\SingletonInterface;

class MongoDBManagerInterface implements MongoDBDatabaseProviderInterface, SingletonInterface, InjectorInterface
{

	/** @var Client $client */
	private $client;

	/** @var Database[] $databases */
	private $databases;

	/**
	 * MongoDBManager constructor.
	 * @param ConfiguratorInterface $config
	 */
	public function __construct(ConfiguratorInterface $config)
	{
		$mongoDbConfig = $config->getConfig('mongodb');
		$this->client = new Client($mongoDbConfig['uri'], $mongoDbConfig['uriOptions'], $mongoDbConfig['driverOptions']);
	}

	public function database(string $database = null): Database
	{
		if ($database === null)
			$database = $this->getDefaultDatabase();

		if (isset($this->databases[$database]) && $this->databases[$database] instanceof Database)
			return $this->databases[$database];

		$mongoDatabase = $this->client->selectDatabase($database);
		$this->databases[$database] = $mongoDatabase;
		return $mongoDatabase;
	}

	public function createInjection(ReflectionClass $class, string $context = null)
	{
		// if context is empty default database will be returned
		return $this->database($context);
	}

	/**
	 * @return string
	 */
	private function getDefaultDatabase(): string
	{
		return 'default';
	}

}
