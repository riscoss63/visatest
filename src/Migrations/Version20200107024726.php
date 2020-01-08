<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107024726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evisa ADD mode_expedition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evisa ADD CONSTRAINT FK_A0057B34735057B2 FOREIGN KEY (mode_expedition_id) REFERENCES mode_expedition (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A0057B34735057B2 ON evisa (mode_expedition_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evisa DROP FOREIGN KEY FK_A0057B34735057B2');
        $this->addSql('DROP INDEX UNIQ_A0057B34735057B2 ON evisa');
        $this->addSql('ALTER TABLE evisa DROP mode_expedition_id');
    }
}
