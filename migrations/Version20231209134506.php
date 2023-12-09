<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231209134506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP img_profil_membre');
        $this->addSql('ALTER TABLE recette DROP img_recette, CHANGE instruction instruction LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD img_profil_membre LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE recette ADD img_recette LONGBLOB DEFAULT NULL, CHANGE instruction instruction VARCHAR(255) DEFAULT NULL');
    }
}
