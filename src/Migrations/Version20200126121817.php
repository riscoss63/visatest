<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126121817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voyageurs ADD attestation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyageurs ADD CONSTRAINT FK_77F668C47EDC5B38 FOREIGN KEY (attestation_id) REFERENCES attestation_assurance (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77F668C47EDC5B38 ON voyageurs (attestation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voyageurs DROP FOREIGN KEY FK_77F668C47EDC5B38');
        $this->addSql('DROP INDEX UNIQ_77F668C47EDC5B38 ON voyageurs');
        $this->addSql('ALTER TABLE voyageurs DROP attestation_id');
    }
}
