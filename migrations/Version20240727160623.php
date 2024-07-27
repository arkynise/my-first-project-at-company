<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727160623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mantonance (numeroMnt INT AUTO_INCREMENT NOT NULL, date_entre DATETIME NOT NULL, date_sorte DATETIME DEFAULT NULL, detail LONGTEXT DEFAULT NULL, numeroEqp INT DEFAULT NULL, INDEX IDX_3CB69BBCD46740FA (numeroEqp), PRIMARY KEY(numeroMnt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mantonance ADD CONSTRAINT FK_3CB69BBCD46740FA FOREIGN KEY (numeroEqp) REFERENCES equipment (numeroEqp)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mantonance DROP FOREIGN KEY FK_3CB69BBCD46740FA');
        $this->addSql('DROP TABLE mantonance');
    }
}
