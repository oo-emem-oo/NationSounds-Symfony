<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312083312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concerts ADD filename VARCHAR(255), CHANGE scene_id scene_id INT');
       // $this->addSql('ALTER TABLE concerts ADD filename VARCHAR(255) NOT NULL, CHANGE scene_id scene_id INT NOT NULL');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concerts DROP filename, CHANGE scene_id scene_id INT DEFAULT NULL');
    }
}
