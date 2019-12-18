<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191206165726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, class_icon VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meet_artist (id INT AUTO_INCREMENT NOT NULL, id_artiste_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_9CE1501C8458D893 (id_artiste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, id_artist_id INT NOT NULL, id_stage_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_320ED90137A2B0DF (id_artist_id), INDEX IDX_320ED90172433D06 (id_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meet_artist ADD CONSTRAINT FK_9CE1501C8458D893 FOREIGN KEY (id_artiste_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90137A2B0DF FOREIGN KEY (id_artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90172433D06 FOREIGN KEY (id_stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE social_media CHANGE url url VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE meet_artist');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('ALTER TABLE social_media CHANGE url url VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
