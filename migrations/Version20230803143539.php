<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803143539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shipping_rate (id INT AUTO_INCREMENT NOT NULL, start_weight DOUBLE PRECISION NOT NULL, end_weight DOUBLE PRECISION NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE shippingrate');
        $this->addSql('ALTER TABLE header CHANGE title title VARCHAR(255) NOT NULL, CHANGE content content LONGTEXT NOT NULL, CHANGE btn_title btn_title VARCHAR(255) NOT NULL, CHANGE btn_url btn_url VARCHAR(255) NOT NULL, CHANGE illustration illustration VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shippingrate (startWeight DOUBLE PRECISION NOT NULL, endWeight DOUBLE PRECISION NOT NULL, rate DOUBLE PRECISION NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE shipping_rate');
        $this->addSql('ALTER TABLE header CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE content content LONGTEXT DEFAULT NULL, CHANGE btn_title btn_title VARCHAR(255) DEFAULT NULL, CHANGE btn_url btn_url VARCHAR(255) DEFAULT NULL, CHANGE illustration illustration VARCHAR(255) DEFAULT NULL');
    }
}
