<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221140617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_user (music_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D9A2D2D2399BBB13 (music_id), INDEX IDX_D9A2D2D2A76ED395 (user_id), PRIMARY KEY(music_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE music_user ADD CONSTRAINT FK_D9A2D2D2399BBB13 FOREIGN KEY (music_id) REFERENCES music (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE music_user ADD CONSTRAINT FK_D9A2D2D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_user DROP FOREIGN KEY FK_D9A2D2D2399BBB13');
        $this->addSql('ALTER TABLE music_user DROP FOREIGN KEY FK_D9A2D2D2A76ED395');
        $this->addSql('DROP TABLE music_user');
    }
}
