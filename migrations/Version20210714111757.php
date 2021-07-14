<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714111757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes ADD acheteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB96A7BB5F FOREIGN KEY (acheteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BD940CBB96A7BB5F ON demandes (acheteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB96A7BB5F');
        $this->addSql('DROP INDEX IDX_BD940CBB96A7BB5F ON demandes');
        $this->addSql('ALTER TABLE demandes DROP acheteur_id');
    }
}
