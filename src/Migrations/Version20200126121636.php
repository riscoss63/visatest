<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126121636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE attestation_assurance (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voyageurs ADD demande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyageurs ADD CONSTRAINT FK_77F668C480E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE INDEX IDX_77F668C480E95E18 ON voyageurs (demande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE attestation_assurance');
        $this->addSql('ALTER TABLE voyageurs DROP FOREIGN KEY FK_77F668C480E95E18');
        $this->addSql('DROP INDEX IDX_77F668C480E95E18 ON voyageurs');
        $this->addSql('ALTER TABLE voyageurs DROP demande_id');
    }
}
