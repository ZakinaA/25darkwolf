<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013134357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoire (id INT AUTO_INCREMENT NOT NULL, instrument_id INT DEFAULT NULL, libelle VARCHAR(50) DEFAULT NULL, INDEX IDX_8FD026ACF11D9C (instrument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_instrument (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couleur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrument (id INT AUTO_INCREMENT NOT NULL, type_instrument_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, num_serie VARCHAR(255) DEFAULT NULL, date_achat DATE DEFAULT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, utilisation VARCHAR(255) DEFAULT NULL, chemin_image VARCHAR(255) DEFAULT NULL, INDEX IDX_3CBF69DD7C1CAAA9 (type_instrument_id), INDEX IDX_3CBF69DD4827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrument_couleur (instrument_id INT NOT NULL, couleur_id INT NOT NULL, INDEX IDX_443EF844CF11D9C (instrument_id), INDEX IDX_443EF844C31BA576 (couleur_id), PRIMARY KEY(instrument_id, couleur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, num_rue INT DEFAULT NULL, rue VARCHAR(50) DEFAULT NULL, copos INT DEFAULT NULL, ville VARCHAR(50) DEFAULT NULL, tel INT DEFAULT NULL, mail VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur_type_instrument (professeur_id INT NOT NULL, type_instrument_id INT NOT NULL, INDEX IDX_1E1989D6BAB22EE9 (professeur_id), INDEX IDX_1E1989D67C1CAAA9 (type_instrument_id), PRIMARY KEY(professeur_id, type_instrument_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_instrument (id INT AUTO_INCREMENT NOT NULL, classe_instrument_id INT DEFAULT NULL, libelle VARCHAR(50) DEFAULT NULL, INDEX IDX_21BCBFF8CE879FB1 (classe_instrument_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessoire ADD CONSTRAINT FK_8FD026ACF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD7C1CAAA9 FOREIGN KEY (type_instrument_id) REFERENCES type_instrument (id)');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_type_instrument ADD CONSTRAINT FK_1E1989D6BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_type_instrument ADD CONSTRAINT FK_1E1989D67C1CAAA9 FOREIGN KEY (type_instrument_id) REFERENCES type_instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_instrument ADD CONSTRAINT FK_21BCBFF8CE879FB1 FOREIGN KEY (classe_instrument_id) REFERENCES classe_instrument (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoire DROP FOREIGN KEY FK_8FD026ACF11D9C');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD7C1CAAA9');
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD4827B9B2');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844CF11D9C');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844C31BA576');
        $this->addSql('ALTER TABLE professeur_type_instrument DROP FOREIGN KEY FK_1E1989D6BAB22EE9');
        $this->addSql('ALTER TABLE professeur_type_instrument DROP FOREIGN KEY FK_1E1989D67C1CAAA9');
        $this->addSql('ALTER TABLE type_instrument DROP FOREIGN KEY FK_21BCBFF8CE879FB1');
        $this->addSql('DROP TABLE accessoire');
        $this->addSql('DROP TABLE classe_instrument');
        $this->addSql('DROP TABLE couleur');
        $this->addSql('DROP TABLE instrument');
        $this->addSql('DROP TABLE instrument_couleur');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE professeur_type_instrument');
        $this->addSql('DROP TABLE type_instrument');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
