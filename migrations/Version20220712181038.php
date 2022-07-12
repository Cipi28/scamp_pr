<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712181038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD booking_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DEE3863E2 FOREIGN KEY (booking_id_id) REFERENCES booking (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DEE3863E2 ON car (booking_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DEE3863E2');
        $this->addSql('DROP INDEX UNIQ_773DE69DEE3863E2 ON car');
        $this->addSql('ALTER TABLE car DROP booking_id_id');
    }
}
