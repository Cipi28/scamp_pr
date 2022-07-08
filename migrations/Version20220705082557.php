<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705082557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_user (car_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_46F9C2E5C3C6F69F (car_id), INDEX IDX_46F9C2E5A76ED395 (user_id), PRIMARY KEY(car_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_user ADD CONSTRAINT FK_46F9C2E5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_user ADD CONSTRAINT FK_46F9C2E5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD car_id_id INT NOT NULL, ADD plug_id_id INT NOT NULL, DROP car_id, DROP plug_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA0EF1B80 FOREIGN KEY (car_id_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE418BA1A9 FOREIGN KEY (plug_id_id) REFERENCES plug (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA0EF1B80 ON booking (car_id_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE418BA1A9 ON booking (plug_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car_user');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA0EF1B80');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE418BA1A9');
        $this->addSql('DROP INDEX IDX_E00CEDDEA0EF1B80 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE418BA1A9 ON booking');
        $this->addSql('ALTER TABLE booking ADD car_id INT NOT NULL, ADD plug_id INT NOT NULL, DROP car_id_id, DROP plug_id_id');
    }
}
