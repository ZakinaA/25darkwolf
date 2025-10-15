<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013133732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tranche_type (tranche_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_F98E49B2B76F6B31 (tranche_id), INDEX IDX_F98E49B2C54C8C93 (type_id), PRIMARY KEY(tranche_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tranche_type ADD CONSTRAINT FK_F98E49B2B76F6B31 FOREIGN KEY (tranche_id) REFERENCES tranche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tranche_type ADD CONSTRAINT FK_F98E49B2C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tranche_type DROP FOREIGN KEY FK_F98E49B2B76F6B31');
        $this->addSql('ALTER TABLE tranche_type DROP FOREIGN KEY FK_F98E49B2C54C8C93');
        $this->addSql('DROP TABLE tranche_type');
    }
}
