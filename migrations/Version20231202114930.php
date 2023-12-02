<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202114930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, unite_id INT DEFAULT NULL, qte DOUBLE PRECISION NOT NULL, INDEX IDX_987306D889312FE9 (recette_id), INDEX IDX_987306D8933FE08C (ingredient_id), INDEX IDX_987306D8EC4A74AB (unite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite (id INT AUTO_INCREMENT NOT NULL, nom_unit VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D889312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8EC4A74AB FOREIGN KEY (unite_id) REFERENCES unite (id)');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A9933FE08C');
        $this->addSql('ALTER TABLE recette_ingredient DROP FOREIGN KEY FK_17C041A989312FE9');
        $this->addSql('DROP TABLE recette_ingredient');
        $this->addSql('ALTER TABLE ingredient DROP qte_ingr, DROP unite');
        $this->addSql('ALTER TABLE interagir ADD membre_id INT DEFAULT NULL, ADD recette_id INT DEFAULT NULL, ADD note_recette INT NOT NULL');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE interagir ADD CONSTRAINT FK_D492C59B89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('CREATE INDEX IDX_D492C59B6A99F74A ON interagir (membre_id)');
        $this->addSql('CREATE INDEX IDX_D492C59B89312FE9 ON interagir (recette_id)');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB293F8B4396');
        $this->addSql('DROP INDEX IDX_F6B4FB293F8B4396 ON membre');
        $this->addSql('ALTER TABLE membre DROP interagir_id');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63903F8B4396');
        $this->addSql('DROP INDEX IDX_49BB63903F8B4396 ON recette');
        $this->addSql('ALTER TABLE recette ADD note_moyenne DOUBLE PRECISION NOT NULL, DROP interagir_id, DROP stars_recette');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_ingredient (recette_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_17C041A989312FE9 (recette_id), INDEX IDX_17C041A9933FE08C (ingredient_id), PRIMARY KEY(recette_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_ingredient ADD CONSTRAINT FK_17C041A989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D889312FE9');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8933FE08C');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8EC4A74AB');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE unite');
        $this->addSql('ALTER TABLE ingredient ADD qte_ingr DOUBLE PRECISION NOT NULL, ADD unite VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B6A99F74A');
        $this->addSql('ALTER TABLE interagir DROP FOREIGN KEY FK_D492C59B89312FE9');
        $this->addSql('DROP INDEX IDX_D492C59B6A99F74A ON interagir');
        $this->addSql('DROP INDEX IDX_D492C59B89312FE9 ON interagir');
        $this->addSql('ALTER TABLE interagir DROP membre_id, DROP recette_id, DROP note_recette');
        $this->addSql('ALTER TABLE membre ADD interagir_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB293F8B4396 FOREIGN KEY (interagir_id) REFERENCES interagir (id)');
        $this->addSql('CREATE INDEX IDX_F6B4FB293F8B4396 ON membre (interagir_id)');
        $this->addSql('ALTER TABLE recette ADD interagir_id INT DEFAULT NULL, ADD stars_recette DOUBLE PRECISION DEFAULT NULL, DROP note_moyenne');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63903F8B4396 FOREIGN KEY (interagir_id) REFERENCES interagir (id)');
        $this->addSql('CREATE INDEX IDX_49BB63903F8B4396 ON recette (interagir_id)');
    }
}
