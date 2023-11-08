<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108185237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_4C62E6387597D3FE FOREIGN KEY (member_id) REFERENCES members (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E6387597D3FE ON contact (member_id)');
        $this->addSql('CREATE TABLE members (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mep_id INTEGER DEFAULT NULL, full_name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, political_group VARCHAR(255) NOT NULL, national_political_group VARCHAR(255) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE members');
    }
}
