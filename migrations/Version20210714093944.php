<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714093944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBBDC6717EE');
        $this->addSql('DROP INDEX IDX_BD940CBBDC6717EE ON demandes');
        $this->addSql('ALTER TABLE demandes CHANGE type_bien_id_id type_bien_id INT NOT NULL');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBB95B4D7FA FOREIGN KEY (type_bien_id) REFERENCES type_bien (id)');
        $this->addSql('CREATE INDEX IDX_BD940CBB95B4D7FA ON demandes (type_bien_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandes DROP FOREIGN KEY FK_BD940CBB95B4D7FA');
        $this->addSql('DROP INDEX IDX_BD940CBB95B4D7FA ON demandes');
        $this->addSql('ALTER TABLE demandes CHANGE type_bien_id type_bien_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE demandes ADD CONSTRAINT FK_BD940CBBDC6717EE FOREIGN KEY (type_bien_id_id) REFERENCES type_bien (id)');
        $this->addSql('CREATE INDEX IDX_BD940CBBDC6717EE ON demandes (type_bien_id_id)');
    }
}
