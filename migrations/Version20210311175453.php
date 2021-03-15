<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311175453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concerts (id INT AUTO_INCREMENT NOT NULL, scene_id INT NOT NULL, artiste VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, jour VARCHAR(255) NOT NULL, heure TIME NOT NULL, UNIQUE INDEX UNIQ_730600F1166053B4 (scene_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scene (id INT AUTO_INCREMENT NOT NULL, concert_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D979EFDA83C97B2E (concert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concerts ADD CONSTRAINT FK_730600F1166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA83C97B2E FOREIGN KEY (concert_id) REFERENCES concerts (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA83C97B2E');
        $this->addSql('ALTER TABLE concerts DROP FOREIGN KEY FK_730600F1166053B4');
        $this->addSql('DROP TABLE concerts');
        $this->addSql('DROP TABLE scene');
        $this->addSql('DROP TABLE user');
    }
}
