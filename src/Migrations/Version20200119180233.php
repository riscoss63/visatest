<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119180233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doccument_officiel DROP FOREIGN KEY FK_23E5E0246630EDD3');
        $this->addSql('DROP INDEX IDX_23E5E0246630EDD3 ON doccument_officiel');
        $this->addSql('ALTER TABLE doccument_officiel CHANGE visa_classic_id categorie_visa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doccument_officiel ADD CONSTRAINT FK_23E5E024C644DC04 FOREIGN KEY (categorie_visa_id) REFERENCES categorie_visa (id)');
        $this->addSql('CREATE INDEX IDX_23E5E024C644DC04 ON doccument_officiel (categorie_visa_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE doccument_officiel DROP FOREIGN KEY FK_23E5E024C644DC04');
        $this->addSql('DROP INDEX IDX_23E5E024C644DC04 ON doccument_officiel');
        $this->addSql('ALTER TABLE doccument_officiel CHANGE categorie_visa_id visa_classic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doccument_officiel ADD CONSTRAINT FK_23E5E0246630EDD3 FOREIGN KEY (visa_classic_id) REFERENCES visa_classic (id)');
        $this->addSql('CREATE INDEX IDX_23E5E0246630EDD3 ON doccument_officiel (visa_classic_id)');
    }
}
