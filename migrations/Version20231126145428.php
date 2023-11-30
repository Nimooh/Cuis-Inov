<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126145428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergene (id INT AUTO_INCREMENT NOT NULL, nom_aller VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_recette (id INT AUTO_INCREMENT NOT NULL, nom_cat_recette VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, nom_ingr VARCHAR(255) NOT NULL, qte_ingr DOUBLE PRECISION NOT NULL, unite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_allergene (ingredient_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_99518292933FE08C (ingredient_id), INDEX IDX_995182924646AB2 (allergene_id), PRIMARY KEY(ingredient_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interagir (id INT AUTO_INCREMENT NOT NULL, fav TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, interagir_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom_membre VARCHAR(255) NOT NULL, prnm_membre VARCHAR(255) NOT NULL, img_profil_membre LONGBLOB DEFAULT NULL, cpmembre VARCHAR(6) DEFAULT NULL, adr_membre VARCHAR(50) DEFAULT NULL, ville_membre VARCHAR(50) DEFAULT NULL, tel_membre VARCHAR(10) DEFAULT NULL, INDEX IDX_F6B4FB293F8B4396 (interagir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, interagir_id INT DEFAULT NULL, nom_recette VARCHAR(255) NOT NULL, temps_recette TIME DEFAULT NULL, stars_recette DOUBLE PRECISION DEFAULT NULL, diff_recette INT NOT NULL, img_recette LONGBLOB DEFAULT NULL, instruction VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_49BB63903F8B4396 (interagir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_categorie_recette (recette_id INT NOT NULL, categorie_recette_id INT NOT NULL, INDEX IDX_319D227989312FE9 (recette_id), INDEX IDX_319D227917F8E545 (categorie_recette_id), PRIMARY KEY(recette_id, categorie_recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY(recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_allergene ADD CONSTRAINT FK_99518292933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_allergene ADD CONSTRAINT FK_995182924646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB293F8B4396 FOREIGN KEY (interagir_id) REFERENCES interagir (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63903F8B4396 FOREIGN KEY (interagir_id) REFERENCES interagir (id)');
        $this->addSql('ALTER TABLE recette_categorie_recette ADD CONSTRAINT FK_319D227989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie_recette ADD CONSTRAINT FK_319D227917F8E545 FOREIGN KEY (categorie_recette_id) REFERENCES categorie_recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_allergene DROP FOREIGN KEY FK_99518292933FE08C');
        $this->addSql('ALTER TABLE ingredient_allergene DROP FOREIGN KEY FK_995182924646AB2');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB293F8B4396');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63903F8B4396');
        $this->addSql('ALTER TABLE recette_categorie_recette DROP FOREIGN KEY FK_319D227989312FE9');
        $this->addSql('ALTER TABLE recette_categorie_recette DROP FOREIGN KEY FK_319D227917F8E545');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A989312FE9');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A9933FE08C');
        $this->addSql('DROP TABLE allergene');
        $this->addSql('DROP TABLE categorie_recette');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_allergene');
        $this->addSql('DROP TABLE interagir');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE recette_categorie_recette');
        $this->addSql('DROP TABLE recette_ingredient');
    }
}
