<?php
declare(strict_types=1);

namespace MongoDBInjector;

use MongoDB\Database;

interface MongoDBDatabaseProviderInterface
{

	/**
	 * @param string|null $database
	 * @return Database
	 */
	public function database(string $database = null): Database;

}
