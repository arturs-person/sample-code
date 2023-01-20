<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120204022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generate Admin User';
    }

    public function up(Schema $schema): void
    {
        $username = 'admin';
        $password = password_hash('option123', PASSWORD_DEFAULT);
        $this->connection->executeStatement(
            'INSERT INTO users VALUES(NULL, ?, ?, ?)',
            [
                $username,
                $password,
                date("Y-m-d H:i:s")
            ]);
    }

    public function down(Schema $schema): void
    {
        $builder = $this->connection->createQueryBuilder();

        $data = $builder->select('id', 'username')
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', 'admin')
            ->fetchAssociative();

        if ($data) {
            $id = $data['id'];

            $builder->delete('users')
                ->where('id = :id')
                ->setParameter('id', $id)
                ->executeStatement();
        }
    }
}
