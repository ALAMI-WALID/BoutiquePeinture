<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316081603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE illustration_teinte (id INT AUTO_INCREMENT NOT NULL, illustration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque_teinte (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_teinte (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, illustration_id INT DEFAULT NULL, INDEX IDX_DBAD0ED04827B9B2 (marque_id), INDEX IDX_DBAD0ED05926566C (illustration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE search_teinte ADD CONSTRAINT FK_DBAD0ED04827B9B2 FOREIGN KEY (marque_id) REFERENCES marque_teinte (id)');
        $this->addSql('ALTER TABLE search_teinte ADD CONSTRAINT FK_DBAD0ED05926566C FOREIGN KEY (illustration_id) REFERENCES illustration_teinte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_teinte DROP FOREIGN KEY FK_DBAD0ED04827B9B2');
        $this->addSql('ALTER TABLE search_teinte DROP FOREIGN KEY FK_DBAD0ED05926566C');
        $this->addSql('DROP TABLE illustration_teinte');
        $this->addSql('DROP TABLE marque_teinte');
        $this->addSql('DROP TABLE search_teinte');
    }
}
