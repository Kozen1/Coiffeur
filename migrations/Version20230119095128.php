<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119095128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1EACDAC0A');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, user_id INT NOT NULL, prestations_id INT NOT NULL, rendezvous DATETIME NOT NULL, INDEX IDX_C09A9BA81B65292 (employe_id), INDEX IDX_C09A9BA8A76ED395 (user_id), INDEX IDX_C09A9BA88BE96D0D (prestations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA81B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA88BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id)');
        $this->addSql('DROP TABLE barbe');
        $this->addSql('DROP INDEX IDX_B338D8D1EACDAC0A ON prestations');
        $this->addSql('ALTER TABLE prestations ADD nom VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD duree TIME NOT NULL, ADD tarif NUMERIC(10, 0) NOT NULL, ADD type VARCHAR(255) NOT NULL, DROP barbe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE barbe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, durée TIME NOT NULL, tarif NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA81B65292');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8A76ED395');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA88BE96D0D');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('ALTER TABLE prestations ADD barbe_id INT NOT NULL, DROP nom, DROP description, DROP duree, DROP tarif, DROP type');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1EACDAC0A FOREIGN KEY (barbe_id) REFERENCES barbe (id)');
        $this->addSql('CREATE INDEX IDX_B338D8D1EACDAC0A ON prestations (barbe_id)');
    }
}
