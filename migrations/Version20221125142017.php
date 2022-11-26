<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125142017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation ADD FormateurID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF57130E6A FOREIGN KEY (FormateurID) REFERENCES formateur (id)');
        $this->addSql('CREATE INDEX IDX_404021BF57130E6A ON formation (FormateurID)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF57130E6A');
        $this->addSql('DROP INDEX IDX_404021BF57130E6A ON formation');
        $this->addSql('ALTER TABLE formation DROP FormateurID');
    }
}
