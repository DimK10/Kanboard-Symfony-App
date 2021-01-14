<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114200313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, workspace_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL, priority SMALLINT NOT NULL, INDEX IDX_2201F24682D40A1F (workspace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, progress_id INT DEFAULT NULL, workspace_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, color VARCHAR(17) NOT NULL, priority SMALLINT NOT NULL, INDEX IDX_527EDB2543DB87C9 (progress_id), INDEX IDX_527EDB2582D40A1F (workspace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_workspace (user_id INT NOT NULL, workspace_id INT NOT NULL, INDEX IDX_8D748DFDA76ED395 (user_id), INDEX IDX_8D748DFD82D40A1F (workspace_id), PRIMARY KEY(user_id, workspace_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workspace (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F24682D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2543DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2582D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('ALTER TABLE user_workspace ADD CONSTRAINT FK_8D748DFDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_workspace ADD CONSTRAINT FK_8D748DFD82D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2543DB87C9');
        $this->addSql('ALTER TABLE user_workspace DROP FOREIGN KEY FK_8D748DFDA76ED395');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F24682D40A1F');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2582D40A1F');
        $this->addSql('ALTER TABLE user_workspace DROP FOREIGN KEY FK_8D748DFD82D40A1F');
        $this->addSql('DROP TABLE progress');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_workspace');
        $this->addSql('DROP TABLE workspace');
    }
}
