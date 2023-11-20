<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119153851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY(recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient ADD id_aller_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870137CF661 FOREIGN KEY (id_aller_id) REFERENCES allergene (id)');
        $this->addSql('CREATE INDEX IDX_6BAF7870137CF661 ON ingredient (id_aller_id)');
        $this->addSql('ALTER TABLE interagir ADD id_interagir_id INT NOT NULL, ADD id_recette_id INT NOT NULL');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B1C4A36E4 FOREIGN KEY (id_interagir_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B2CBBAF3E FOREIGN KEY (id_recette_id) REFERENCES recette (id)');
        $this->addSql('CREATE INDEX IDX_D492C59B1C4A36E4 ON interagir (id_interagir_id)');
        $this->addSql('CREATE INDEX IDX_D492C59B2CBBAF3E ON interagir (id_recette_id)');
        $this->addSql('ALTER TABLE membre CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE recette ADD id_cat_recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB639069B5B91E FOREIGN KEY (id_cat_recette_id) REFERENCES categorie_recette (id)');
        $this->addSql('CREATE INDEX IDX_49BB639069B5B91E ON recette (id_cat_recette_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A989312FE9');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A9933FE08C');
        $this->addSql('DROP TABLE recette_ingredient');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870137CF661');
        $this->addSql('DROP INDEX IDX_6BAF7870137CF661 ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP id_aller_id');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B1C4A36E4');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B2CBBAF3E');
        $this->addSql('DROP INDEX IDX_D492C59B1C4A36E4 ON interagir');
        $this->addSql('DROP INDEX IDX_D492C59B2CBBAF3E ON interagir');
        $this->addSql('ALTER TABLE interagir DROP id_interagir_id, DROP id_recette_id');
        $this->addSql('ALTER TABLE membre CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin` COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB639069B5B91E');
        $this->addSql('DROP INDEX IDX_49BB639069B5B91E ON recette');
        $this->addSql('ALTER TABLE recette DROP id_cat_recette_id');
    }
}
