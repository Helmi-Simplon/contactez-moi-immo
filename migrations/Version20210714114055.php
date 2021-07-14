<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714114055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offres (id INT AUTO_INCREMENT NOT NULL, type_bien_id INT NOT NULL, vendeur_id INT NOT NULL, adresse_id INT NOT NULL, titre VARCHAR(255) NOT NULL, superficie DOUBLE PRECISION NOT NULL, nbre_pieces INT DEFAULT NULL, nbre_appartements INT DEFAULT NULL, nbre_studios INT DEFAULT NULL, places_parking INT DEFAULT NULL, cave INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, date_offre DATETIME NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(120) NOT NULL, INDEX IDX_C6AC354495B4D7FA (type_bien_id), INDEX IDX_C6AC3544858C065E (vendeur_id), INDEX IDX_C6AC35444DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC354495B4D7FA FOREIGN KEY (type_bien_id) REFERENCES type_bien (id)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC35444DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offres');
    }
}
