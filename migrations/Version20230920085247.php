<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920085247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, sscategory_id INT DEFAULT NULL, scategory_id INT DEFAULT NULL, buses_id INT DEFAULT NULL, size_gobelet_id INT DEFAULT NULL, filtre_peinture_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, article_code VARCHAR(255) NOT NULL, livrable_hors_ile_de_france TINYINT(1) NOT NULL, is_best TINYINT(1) NOT NULL, promo TINYINT(1) DEFAULT NULL, filtre_contenance VARCHAR(255) DEFAULT NULL, pack_vernis_filtre VARCHAR(255) DEFAULT NULL, diluant VARCHAR(255) DEFAULT NULL, grain VARCHAR(255) DEFAULT NULL, dimension_cale VARCHAR(255) DEFAULT NULL, matiere_papier VARCHAR(255) DEFAULT NULL, qualite_papier VARCHAR(255) DEFAULT NULL, epaisseur_ruban VARCHAR(255) DEFAULT NULL, dimension_papier_cacher VARCHAR(255) DEFAULT NULL, colors_appret VARCHAR(255) DEFAULT NULL, raccord_air VARCHAR(255) DEFAULT NULL, dimension_tuyau VARCHAR(255) DEFAULT NULL, type_tuyau VARCHAR(255) DEFAULT NULL, dimensionfiltre_cabine VARCHAR(255) DEFAULT NULL, type_filtre_cabine VARCHAR(255) DEFAULT NULL, taille_equipement_protection VARCHAR(255) DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD225F29C2 (sscategory_id), INDEX IDX_D34A04AD51C0B965 (scategory_id), INDEX IDX_D34A04AD75521321 (buses_id), INDEX IDX_D34A04AD917D620E (size_gobelet_id), INDEX IDX_D34A04AD71E18A54 (filtre_peinture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD225F29C2 FOREIGN KEY (sscategory_id) REFERENCES sous_sous_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD51C0B965 FOREIGN KEY (scategory_id) REFERENCES sous_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD75521321 FOREIGN KEY (buses_id) REFERENCES buses (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD917D620E FOREIGN KEY (size_gobelet_id) REFERENCES contenance (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD71E18A54 FOREIGN KEY (filtre_peinture_id) REFERENCES pcfes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD225F29C2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD51C0B965');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD75521321');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD917D620E');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD71E18A54');
        $this->addSql('DROP TABLE product');
    }
}
