<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606125611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sous_sous_category (id INT AUTO_INCREMENT NOT NULL, id_sous_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3365281BB1F5BB00 (id_sous_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sous_sous_category ADD CONSTRAINT FK_3365281BB1F5BB00 FOREIGN KEY (id_sous_category_id) REFERENCES sous_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_sous_category DROP FOREIGN KEY FK_3365281BB1F5BB00');
        $this->addSql('DROP TABLE sous_sous_category');
    }
}
