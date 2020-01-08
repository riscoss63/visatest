<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104235128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, transport_id INT DEFAULT NULL, client_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, UNIQUE INDEX UNIQ_2694D7A59909C13F (transport_id), INDEX IDX_2694D7A519EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyageurs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postale VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, INDEX IDX_77F668C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A59909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A519EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voyageurs ADD CONSTRAINT FK_77F668C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE visa_type ADD demande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visa_type ADD CONSTRAINT FK_A3E5D30780E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE INDEX IDX_A3E5D30780E95E18 ON visa_type (demande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visa_type DROP FOREIGN KEY FK_A3E5D30780E95E18');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE voyageurs');
        $this->addSql('DROP INDEX IDX_A3E5D30780E95E18 ON visa_type');
        $this->addSql('ALTER TABLE visa_type DROP demande_id');
    }
}
