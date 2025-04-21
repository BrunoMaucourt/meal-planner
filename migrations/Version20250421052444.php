<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421052444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, date DATE NOT NULL, meal_time VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, estimated_calories DOUBLE PRECISION DEFAULT NULL, estimated_proteins DOUBLE PRECISION DEFAULT NULL, estimated_fats DOUBLE PRECISION DEFAULT NULL, estimated_carbs DOUBLE PRECISION DEFAULT NULL, meal_source VARCHAR(255) NOT NULL, external_name VARCHAR(255) DEFAULT NULL, INDEX IDX_9EF68E9C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE meal
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
