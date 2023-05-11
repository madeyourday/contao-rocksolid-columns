<?php
/*
 * Copyright MADE/YOUR/DAY OG <mail@madeyourday.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MadeYourDay\RockSolidColumns\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class ColumnsXLargeMigration extends AbstractMigration
{
	private Connection $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function shouldRun(): bool
	{
		$schemaManager = $this->connection->createSchemaManager();

		if (!$schemaManager->tablesExist(['tl_content'])) {
			return false;
		}

		$columns = $schemaManager->listTableColumns('tl_content');

		if (!isset($columns['rs_columns_large'])) {
			return false;
		}

		return !isset($columns['rs_columns_xlarge']);
	}

	public function run(): MigrationResult
	{
		$schemaManager = $this->connection->createSchemaManager();
		$columns = $schemaManager->listTableColumns('tl_content');

		if (!isset($columns['rs_columns_xlarge'])) {
			$this->connection->executeStatement("ALTER TABLE tl_content ADD rs_columns_xlarge VARCHAR(255) DEFAULT '' NOT NULL");
			$this->connection->executeStatement("UPDATE tl_content SET rs_columns_xlarge = rs_columns_large WHERE rs_columns_large != ''");
		}

		return $this->createResult(true);
	}
}
