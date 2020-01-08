<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104050134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tarif_transport_departements DROP FOREIGN KEY FK_234A90331DB279A6');
        $this->addSql('CREATE TABLE departemente (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, nom_uppercase VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, nom_soundex VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarif_transport_departemente (tarif_transport_id INT NOT NULL, departemente_id INT NOT NULL, INDEX IDX_D79E2562852BF533 (tarif_transport_id), INDEX IDX_D79E256268C071E5 (departemente_id), PRIMARY KEY(tarif_transport_id, departemente_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tarif_transport_departemente ADD CONSTRAINT FK_D79E2562852BF533 FOREIGN KEY (tarif_transport_id) REFERENCES tarif_transport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_transport_departemente ADD CONSTRAINT FK_D79E256268C071E5 FOREIGN KEY (departemente_id) REFERENCES departemente (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE departements');
        $this->addSql('DROP TABLE tarif_transport_departement');
        $this->addSql('DROP TABLE tarif_transport_departements');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tarif_transport_departemente DROP FOREIGN KEY FK_D79E256268C071E5');
        $this->addSql('CREATE TABLE departements (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, uppercase VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom_soundex VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tarif_transport_departement (tarif_transport_id INT NOT NULL, departement_id INT NOT NULL, INDEX IDX_9C9DFCA2CCF9E01E (departement_id), INDEX IDX_9C9DFCA2852BF533 (tarif_transport_id), PRIMARY KEY(tarif_transport_id, departement_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tarif_transport_departements (tarif_transport_id INT NOT NULL, departements_id INT NOT NULL, INDEX IDX_234A90331DB279A6 (departements_id), INDEX IDX_234A9033852BF533 (tarif_transport_id), PRIMARY KEY(tarif_transport_id, departements_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tarif_transport_departement ADD CONSTRAINT FK_9C9DFCA2852BF533 FOREIGN KEY (tarif_transport_id) REFERENCES tarif_transport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_transport_departements ADD CONSTRAINT FK_234A90331DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif_transport_departements ADD CONSTRAINT FK_234A9033852BF533 FOREIGN KEY (tarif_transport_id) REFERENCES tarif_transport (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE departemente');
        $this->addSql('DROP TABLE tarif_transport_departemente');
    }
}
