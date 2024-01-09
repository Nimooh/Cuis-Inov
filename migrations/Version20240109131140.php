<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109131140 extends AbstractMigration
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
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, unite_id INT DEFAULT NULL, qte DOUBLE PRECISION NOT NULL, INDEX IDX_987306D889312FE9 (recette_id), INDEX IDX_987306D8933FE08C (ingredient_id), INDEX IDX_987306D8EC4A74AB (unite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, nom_ingr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_allergene (ingredient_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_99518292933FE08C (ingredient_id), INDEX IDX_995182924646AB2 (allergene_id), PRIMARY KEY(ingredient_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interagir (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, recette_id INT DEFAULT NULL, fav TINYINT(1) DEFAULT NULL, note_recette INT DEFAULT NULL, INDEX IDX_D492C59B6A99F74A (membre_id), INDEX IDX_D492C59B89312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom_membre VARCHAR(255) NOT NULL, prnm_membre VARCHAR(255) NOT NULL, tel_membre VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_allergene (membre_id INT NOT NULL, allergene_id INT NOT NULL, INDEX IDX_2C46291B6A99F74A (membre_id), INDEX IDX_2C46291B4646AB2 (allergene_id), PRIMARY KEY(membre_id, allergene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, nom_recette VARCHAR(255) NOT NULL, temps_recette VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', diff_recette INT NOT NULL, instruction LONGTEXT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, note_moyenne DOUBLE PRECISION NOT NULL, nb_pers INT NOT NULL, INDEX IDX_49BB63906A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette_categorie_recette (recette_id INT NOT NULL, categorie_recette_id INT NOT NULL, INDEX IDX_319D227989312FE9 (recette_id), INDEX IDX_319D227917F8E545 (categorie_recette_id), PRIMARY KEY(recette_id, categorie_recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite (id INT AUTO_INCREMENT NOT NULL, nom_unit VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D889312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8EC4A74AB FOREIGN KEY (unite_id) REFERENCES unite (id)');
        $this->addSql('ALTER TABLE ingredient_allergene ADD CONSTRAINT FK_99518292933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_allergene ADD CONSTRAINT FK_995182924646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE membre_allergene ADD CONSTRAINT FK_2C46291B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_allergene ADD CONSTRAINT FK_2C46291B4646AB2 FOREIGN KEY (allergene_id) REFERENCES allergene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63906A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE recette_categorie_recette ADD CONSTRAINT FK_319D227989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_categorie_recette ADD CONSTRAINT FK_319D227917F8E545 FOREIGN KEY (categorie_recette_id) REFERENCES categorie_recette (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D889312FE9');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8933FE08C');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8EC4A74AB');
        $this->addSql('ALTER TABLE ingredient_allergene DROP FOREIGN KEY FK_99518292933FE08C');
        $this->addSql('ALTER TABLE ingredient_allergene DROP FOREIGN KEY FK_995182924646AB2');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B6A99F74A');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B89312FE9');
        $this->addSql('ALTER TABLE membre_allergene DROP FOREIGN KEY FK_2C46291B6A99F74A');
        $this->addSql('ALTER TABLE membre_allergene DROP FOREIGN KEY FK_2C46291B4646AB2');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63906A99F74A');
        $this->addSql('ALTER TABLE recette_categorie_recette DROP FOREIGN KEY FK_319D227989312FE9');
        $this->addSql('ALTER TABLE recette_categorie_recette DROP FOREIGN KEY FK_319D227917F8E545');
        $this->addSql('DROP TABLE allergene');
        $this->addSql('DROP TABLE categorie_recette');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_allergene');
        $this->addSql('DROP TABLE interagir');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE membre_allergene');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE recette_categorie_recette');
        $this->addSql('DROP TABLE unite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
