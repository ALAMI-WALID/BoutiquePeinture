<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527225320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE base_officielle_des_codes_postaux ADD id INT AUTO_INCREMENT NOT NULL, CHANGE Code_postale code_postale INT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE base_officielle_des_codes_postaux MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON base_officielle_des_codes_postaux');
        $this->addSql('ALTER TABLE base_officielle_des_codes_postaux DROP id, CHANGE code_postale Code_postale INT DEFAULT NULL');
    }
}
