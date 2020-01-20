<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119173922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE doccument_officiel (id INT AUTO_INCREMENT NOT NULL, visa_classic_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_23E5E0246630EDD3 (visa_classic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doccument_officiel ADD CONSTRAINT FK_23E5E0246630EDD3 FOREIGN KEY (visa_classic_id) REFERENCES visa_classic (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE doccument_officiel');
    }
}
