<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105045505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE demande_visa_type');
        $this->addSql('ALTER TABLE demande ADD visa_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5197B533D FOREIGN KEY (visa_type_id) REFERENCES visa_type (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5197B533D ON demande (visa_type_id)');
        $this->addSql('ALTER TABLE visa_type DROP FOREIGN KEY FK_A3E5D30780E95E18');
        $this->addSql('DROP INDEX IDX_A3E5D30780E95E18 ON visa_type');
        $this->addSql('ALTER TABLE visa_type ADD quantite INT NOT NULL, DROP demande_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demande_visa_type (demande_id INT NOT NULL, visa_type_id INT NOT NULL, INDEX IDX_D6C929D2197B533D (visa_type_id), INDEX IDX_D6C929D280E95E18 (demande_id), PRIMARY KEY(demande_id, visa_type_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE demande_visa_type ADD CONSTRAINT FK_D6C929D2197B533D FOREIGN KEY (visa_type_id) REFERENCES visa_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_visa_type ADD CONSTRAINT FK_D6C929D280E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5197B533D');
        $this->addSql('DROP INDEX IDX_2694D7A5197B533D ON demande');
        $this->addSql('ALTER TABLE demande DROP visa_type_id');
        $this->addSql('ALTER TABLE visa_type ADD demande_id INT DEFAULT NULL, DROP quantite');
        $this->addSql('ALTER TABLE visa_type ADD CONSTRAINT FK_A3E5D30780E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('CREATE INDEX IDX_A3E5D30780E95E18 ON visa_type (demande_id)');
    }
}
