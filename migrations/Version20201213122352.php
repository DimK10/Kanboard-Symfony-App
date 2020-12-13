<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213122352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246A6ADFB8');
        $this->addSql('DROP INDEX IDX_2201F246A6ADFB8 ON progress');
        $this->addSql('ALTER TABLE progress CHANGE workspace_id_id workspace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F24682D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('CREATE INDEX IDX_2201F24682D40A1F ON progress (workspace_id)');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB259DFC6D6C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A6ADFB8');
        $this->addSql('DROP INDEX IDX_527EDB259DFC6D6C ON task');
        $this->addSql('DROP INDEX IDX_527EDB25A6ADFB8 ON task');
        $this->addSql('ALTER TABLE task ADD progress_id INT DEFAULT NULL, ADD workspace_id INT DEFAULT NULL, DROP progress_id_id, DROP workspace_id_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2543DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2582D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
        $this->addSql('CREATE INDEX IDX_527EDB2543DB87C9 ON task (progress_id)');
        $this->addSql('CREATE INDEX IDX_527EDB2582D40A1F ON task (workspace_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F24682D40A1F');
        $this->addSql('DROP INDEX IDX_2201F24682D40A1F ON progress');
        $this->addSql('ALTER TABLE progress CHANGE workspace_id workspace_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246A6ADFB8 FOREIGN KEY (workspace_id_id) REFERENCES workspace (id)');
        $this->addSql('CREATE INDEX IDX_2201F246A6ADFB8 ON progress (workspace_id_id)');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2543DB87C9');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2582D40A1F');
        $this->addSql('DROP INDEX IDX_527EDB2543DB87C9 ON task');
        $this->addSql('DROP INDEX IDX_527EDB2582D40A1F ON task');
        $this->addSql('ALTER TABLE task ADD progress_id_id INT DEFAULT NULL, ADD workspace_id_id INT DEFAULT NULL, DROP progress_id, DROP workspace_id');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB259DFC6D6C FOREIGN KEY (progress_id_id) REFERENCES progress (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A6ADFB8 FOREIGN KEY (workspace_id_id) REFERENCES workspace (id)');
        $this->addSql('CREATE INDEX IDX_527EDB259DFC6D6C ON task (progress_id_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25A6ADFB8 ON task (workspace_id_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
