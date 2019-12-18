<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191213132257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meet_artist DROP FOREIGN KEY FK_9CE1501C8458D893');
        $this->addSql('DROP INDEX IDX_9CE1501C8458D893 ON meet_artist');
        $this->addSql('ALTER TABLE meet_artist CHANGE id_artiste_id artiste_id INT NOT NULL');
        $this->addSql('ALTER TABLE meet_artist ADD CONSTRAINT FK_9CE1501C21D25844 FOREIGN KEY (artiste_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_9CE1501C21D25844 ON meet_artist (artiste_id)');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90137A2B0DF');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED90172433D06');
        $this->addSql('DROP INDEX IDX_320ED90172433D06 ON `show`');
        $this->addSql('DROP INDEX IDX_320ED90137A2B0DF ON `show`');
        $this->addSql('ALTER TABLE `show` ADD artist_id INT NOT NULL, ADD stage_id INT NOT NULL, DROP id_artist_id, DROP id_stage_id');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED901B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED9012298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('CREATE INDEX IDX_320ED901B7970CF8 ON `show` (artist_id)');
        $this->addSql('CREATE INDEX IDX_320ED9012298D193 ON `show` (stage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meet_artist DROP FOREIGN KEY FK_9CE1501C21D25844');
        $this->addSql('DROP INDEX IDX_9CE1501C21D25844 ON meet_artist');
        $this->addSql('ALTER TABLE meet_artist CHANGE artiste_id id_artiste_id INT NOT NULL');
        $this->addSql('ALTER TABLE meet_artist ADD CONSTRAINT FK_9CE1501C8458D893 FOREIGN KEY (id_artiste_id) REFERENCES artist (id)');
        $this->addSql('CREATE INDEX IDX_9CE1501C8458D893 ON meet_artist (id_artiste_id)');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED901B7970CF8');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED9012298D193');
        $this->addSql('DROP INDEX IDX_320ED901B7970CF8 ON `show`');
        $this->addSql('DROP INDEX IDX_320ED9012298D193 ON `show`');
        $this->addSql('ALTER TABLE `show` ADD id_artist_id INT NOT NULL, ADD id_stage_id INT NOT NULL, DROP artist_id, DROP stage_id');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90137A2B0DF FOREIGN KEY (id_artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED90172433D06 FOREIGN KEY (id_stage_id) REFERENCES stage (id)');
        $this->addSql('CREATE INDEX IDX_320ED90172433D06 ON `show` (id_stage_id)');
        $this->addSql('CREATE INDEX IDX_320ED90137A2B0DF ON `show` (id_artist_id)');
    }
}
