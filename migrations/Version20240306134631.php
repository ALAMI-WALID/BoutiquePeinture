<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306134631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paint_estimations ADD car_type_id INT DEFAULT NULL, ADD paint_option_id INT DEFAULT NULL, ADD paint_quantity VARCHAR(255) NOT NULL, ADD bombe_quantity INT NOT NULL');
        $this->addSql('ALTER TABLE paint_estimations ADD CONSTRAINT FK_3180B0D496E7774F FOREIGN KEY (car_type_id) REFERENCES car_type (id)');
        $this->addSql('ALTER TABLE paint_estimations ADD CONSTRAINT FK_3180B0D4CF712DC1 FOREIGN KEY (paint_option_id) REFERENCES paint_options (id)');
        $this->addSql('CREATE INDEX IDX_3180B0D496E7774F ON paint_estimations (car_type_id)');
        $this->addSql('CREATE INDEX IDX_3180B0D4CF712DC1 ON paint_estimations (paint_option_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paint_estimations DROP FOREIGN KEY FK_3180B0D496E7774F');
        $this->addSql('ALTER TABLE paint_estimations DROP FOREIGN KEY FK_3180B0D4CF712DC1');
        $this->addSql('DROP INDEX IDX_3180B0D496E7774F ON paint_estimations');
        $this->addSql('DROP INDEX IDX_3180B0D4CF712DC1 ON paint_estimations');
        $this->addSql('ALTER TABLE paint_estimations DROP car_type_id, DROP paint_option_id, DROP paint_quantity, DROP bombe_quantity');
    }
}
