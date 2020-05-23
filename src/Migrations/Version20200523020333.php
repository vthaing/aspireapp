<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523020333 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE loan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, monthly_net_income DOUBLE PRECISION NOT NULL, loan_amount DOUBLE PRECISION NOT NULL, loan_term SMALLINT NOT NULL, status SMALLINT NOT NULL, interest_rate DOUBLE PRECISION DEFAULT NULL, first_repayment_date DATE DEFAULT NULL, next_repayment_date DATE DEFAULT NULL, repayment_frequency SMALLINT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_C5D30D03A76ED395 ON loan (user_id)');
        $this->addSql('CREATE TABLE loan_repayment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, loan_id INTEGER NOT NULL, user_id INTEGER NOT NULL, amount DOUBLE PRECISION NOT NULL, status SMALLINT NOT NULL, pay_for_repayment_date DATE NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_114036CBCE73868F ON loan_repayment (loan_id)');
        $this->addSql('CREATE INDEX IDX_114036CBA76ED395 ON loan_repayment (user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP TABLE test');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE test (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE loan_repayment');
        $this->addSql('DROP TABLE user');
    }
}
