<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240105175848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre_allergene (membre_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_2C46291B6A99F74A (membre_id), INDEX IDX_2C46291B4646AB2 (allergene_id), PRIMARY KEY(membre_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_allergene ADD CONSTRAINT FK_2C46291B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_allergene ADD CONSTRAINT FK_2C46291B4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_allergene DROP FOREIGN KEY FK_2C46291B6A99F74A');
        $this->addSql('ALTER TABLE membre_allergene DROP FOREIGN KEY FK_2C46291B4646AB2');
        $this->addSql('DROP TABLE membre_allergene');
    }
}
