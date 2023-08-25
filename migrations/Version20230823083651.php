<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823083651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD75521321');
        $this->addSql('CREATE TABLE pot_bd (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, price_bd DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE buses');
        $this->addSql('DROP INDEX IDX_D34A04AD75521321 ON product');
        $this->addSql('ALTER TABLE product DROP buses_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE buses (id INT AUTO_INCREMENT NOT NULL, size DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE pot_bd');
        $this->addSql('ALTER TABLE product ADD buses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD75521321 FOREIGN KEY (buses_id) REFERENCES buses (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD75521321 ON product (buses_id)');
    }
}