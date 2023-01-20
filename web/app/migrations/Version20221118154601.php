<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118154601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table Users.';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('username', 'string');
        $table->addColumn('password', 'string');
        $table->addColumn('created_at', 'datetime');
        $table->setPrimaryKey(['id']);
        $table->addUniqueConstraint(['username']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
    }
}
