<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721125241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes ADD actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE offres ADD actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD actif TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP actif');
        $this->addSql('ALTER TABLE offres DROP actif');
        $this->addSql('ALTER TABLE user DROP actif');
    }
}
