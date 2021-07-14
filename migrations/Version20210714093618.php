<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714093618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demandes (id INT AUTO_INCREMENT NOT NULL, type_bien_id_id INT NOT NULL, titre VARCHAR(255) NOT NULL, superficie DOUBLE PRECISION NOT NULL, nbre_pieces INT DEFAULT NULL, nbre_appartements INT DEFAULT NULL, nbre_studios INT DEFAULT NULL, nbre_parking INT DEFAULT NULL, cave INT DEFAULT NULL, budget DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, date_demande DATETIME NOT NULL, slug VARCHAR(120) NOT NULL, INDEX IDX_BD940CBBDC6717EE (type_bien_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBDC6717EE FOREIGN KEY (type_bien_id_id) REFERENCES type_bien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE demandes');
    }
}
