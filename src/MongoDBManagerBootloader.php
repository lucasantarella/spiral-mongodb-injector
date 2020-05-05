<?php
declare(strict_types=1);


namespace MongoDBInjector;

use MongoDB\Database;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Core\Container;
use Spiral\Core\Container\SingletonInterface;

final class MongoDBManagerBootloader extends Bootloader implements SingletonInterface
{

	/**
	 * @var ConfiguratorInterface $config
	 */
	private $config;


	/**
	 * @param ConfiguratorInterface $config
	 */
	public function __construct(ConfiguratorInterface $config)
	{
		$this->config = $config;
	}

	/**
	 * Init database config.
	 * @param Container $container
	 */
	public function boot(Container $container): void
	{
		$this->config->setDefaults(
			'mongodb',
			[
				'uri' => '',
				'uriOptions' => [],
				'driverOptions' => []
			]
		);

		$container->bindInjector(Database::class, MongoDBManagerInterface::class);
	}
}
