<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107012612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evisa (id INT AUTO_INCREMENT NOT NULL, meta_id INT DEFAULT NULL, pays_id INT DEFAULT NULL, notre_service_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, active TINYINT(1) NOT NULL, communique VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A0057B3439FCA6F9 (meta_id), UNIQUE INDEX UNIQ_A0057B34A6E44244 (pays_id), UNIQUE INDEX UNIQ_A0057B349FC4B0FC (notre_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evisa ADD CONSTRAINT FK_A0057B3439FCA6F9 FOREIGN KEY (meta_id) REFERENCES meta (id)');
        $this->addSql('ALTER TABLE evisa ADD CONSTRAINT FK_A0057B34A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE evisa ADD CONSTRAINT FK_A0057B349FC4B0FC FOREIGN KEY (notre_service_id) REFERENCES notre_service (id)');
        $this->addSql('ALTER TABLE visa_type ADD e_visa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visa_type ADD CONSTRAINT FK_A3E5D30778509CF7 FOREIGN KEY (e_visa_id) REFERENCES evisa (id)');
        $this->addSql('CREATE INDEX IDX_A3E5D30778509CF7 ON visa_type (e_visa_id)');
        $this->addSql('ALTER TABLE volet_info ADD e_visa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE volet_info ADD CONSTRAINT FK_5F0FCEC78509CF7 FOREIGN KEY (e_visa_id) REFERENCES evisa (id)');
        $this->addSql('CREATE INDEX IDX_5F0FCEC78509CF7 ON volet_info (e_visa_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visa_type DROP FOREIGN KEY FK_A3E5D30778509CF7');
        $this->addSql('ALTER TABLE volet_info DROP FOREIGN KEY FK_5F0FCEC78509CF7');
        $this->addSql('DROP TABLE evisa');
        $this->addSql('DROP INDEX IDX_A3E5D30778509CF7 ON visa_type');
        $this->addSql('ALTER TABLE visa_type DROP e_visa_id');
        $this->addSql('DROP INDEX IDX_5F0FCEC78509CF7 ON volet_info');
        $this->addSql('ALTER TABLE volet_info DROP e_visa_id');
    }
}
