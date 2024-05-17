<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240517090612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editor (id INT AUTO_INCREMENT NOT NULL, main_image_id INT DEFAULT NULL, name VARCHAR(80) NOT NULL, UNIQUE INDEX UNIQ_CCF1F1BAE4873418 (main_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, editor_id INT DEFAULT NULL, main_image_id INT DEFAULT NULL, author_id INT DEFAULT NULL, title VARCHAR(120) NOT NULL, description LONGTEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, date_sortie DATETIME NOT NULL, INDEX IDX_232B318C6995AC4C (editor_id), UNIQUE INDEX UNIQ_232B318CE4873418 (main_image_id), INDEX IDX_232B318CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_support (game_id INT NOT NULL, support_id INT NOT NULL, INDEX IDX_15C6948AE48FD905 (game_id), INDEX IDX_15C6948A315B405 (support_id), PRIMARY KEY(game_id, support_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_AA08CB10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, constructeur_id INT DEFAULT NULL, main_image_id INT DEFAULT NULL, author_id INT DEFAULT NULL, nom VARCHAR(80) NOT NULL, date_sortie DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_8004EBA58815B605 (constructeur_id), UNIQUE INDEX UNIQ_8004EBA5E4873418 (main_image_id), INDEX IDX_8004EBA5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE editor ADD CONSTRAINT FK_CCF1F1BAE4873418 FOREIGN KEY (main_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE4873418 FOREIGN KEY (main_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_support ADD CONSTRAINT FK_15C6948AE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_support ADD CONSTRAINT FK_15C6948A315B405 FOREIGN KEY (support_id) REFERENCES support (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA58815B605 FOREIGN KEY (constructeur_id) REFERENCES editor (id)');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5E4873418 FOREIGN KEY (main_image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editor DROP FOREIGN KEY FK_CCF1F1BAE4873418');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6995AC4C');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE4873418');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF675F31B');
        $this->addSql('ALTER TABLE game_support DROP FOREIGN KEY FK_15C6948AE48FD905');
        $this->addSql('ALTER TABLE game_support DROP FOREIGN KEY FK_15C6948A315B405');
        $this->addSql('ALTER TABLE login DROP FOREIGN KEY FK_AA08CB10A76ED395');
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA58815B605');
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5E4873418');
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5F675F31B');
        $this->addSql('DROP TABLE editor');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_support');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}