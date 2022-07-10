<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710094520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, car_id_id INT NOT NULL, INDEX IDX_D87F7E0CA0EF1B80 (car_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CA0EF1B80 FOREIGN KEY (car_id_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE booking CHANGE duration duration TIME NOT NULL, CHANGE start_time start_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_car ADD CONSTRAINT FK_9C2B8716C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE user_car ADD CONSTRAINT FK_9C2B8716A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE booking CHANGE duration duration INT NOT NULL, CHANGE start_time start_time INT NOT NULL');
        $this->addSql('ALTER TABLE user_car DROP FOREIGN KEY FK_9C2B8716C3C6F69F');
        $this->addSql('ALTER TABLE user_car DROP FOREIGN KEY FK_9C2B8716A76ED395');
    }
}
