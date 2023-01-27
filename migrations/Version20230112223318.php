<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112223318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barbe DROP FOREIGN KEY FK_9B2C639A8BE96D0D');
        $this->addSql('DROP INDEX IDX_9B2C639A8BE96D0D ON barbe');
        $this->addSql('ALTER TABLE barbe DROP prestations_id');
        $this->addSql('ALTER TABLE prestations ADD barbe_id INT NOT NULL');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1EACDAC0A FOREIGN KEY (barbe_id) REFERENCES barbe (id)');
        $this->addSql('CREATE INDEX IDX_B338D8D1EACDAC0A ON prestations (barbe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barbe ADD prestations_id INT NOT NULL');
        $this->addSql('ALTER TABLE barbe ADD CONSTRAINT FK_9B2C639A8BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id)');
        $this->addSql('CREATE INDEX IDX_9B2C639A8BE96D0D ON barbe (prestations_id)');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1EACDAC0A');
        $this->addSql('DROP INDEX IDX_B338D8D1EACDAC0A ON prestations');
        $this->addSql('ALTER TABLE prestations DROP barbe_id');
    }
}
