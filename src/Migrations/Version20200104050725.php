<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104050725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tarif_transport_departemente');
        $this->addSql('ALTER TABLE tarif_transport ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarif_transport ADD CONSTRAINT FK_55AEF91FCCF9E01E FOREIGN KEY (departement_id) REFERENCES departemente (id)');
        $this->addSql('CREATE INDEX IDX_55AEF91FCCF9E01E ON tarif_transport (departement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tarif_transport_departemente (tarif_transport_id INT NOT NULL, departemente_id INT NOT NULL, INDEX IDX_D79E256268C071E5 (departemente_id), INDEX IDX_D79E2562852BF533 (tarif_transport_id), PRIMARY KEY(tarif_transport_id, departemente_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tarif_transport_departemente ADD CONSTRAINT FK_D79E256268C071E5 FOREIGN KEY (departemente_id) REFERENCES departemente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_transport_departemente ADD CONSTRAINT FK_D79E2562852BF533 FOREIGN KEY (tarif_transport_id) REFERENCES tarif_transport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_transport DROP FOREIGN KEY FK_55AEF91FCCF9E01E');
        $this->addSql('DROP INDEX IDX_55AEF91FCCF9E01E ON tarif_transport');
        $this->addSql('ALTER TABLE tarif_transport DROP departement_id');
    }
}
