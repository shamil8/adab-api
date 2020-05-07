<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507115832 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poem (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL COMMENT \'Номи шеър\', description LONGTEXT DEFAULT NULL COMMENT \'Тавсиф\', text LONGTEXT NOT NULL COMMENT \'Матни шеър\', created_at DATETIME NOT NULL COMMENT \'Сохтем дар\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'Ном\', surname VARCHAR(255) DEFAULT NULL COMMENT \'Насаб\', full_name VARCHAR(255) NOT NULL COMMENT \'Номи пурра\', biography LONGTEXT DEFAULT NULL COMMENT \'Тарҷумаи ҳол\', date_birth DATE DEFAULT NULL COMMENT \'Саннаи таваллуд\', date_death DATE DEFAULT NULL COMMENT \'Саннаи вафот\', create_at DATETIME NOT NULL COMMENT \'Сохтем дар\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poet_image (id INT AUTO_INCREMENT NOT NULL, poet_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COMMENT \'Номи сурат\', src VARCHAR(255) NOT NULL COMMENT \'Пайванд ба сурат\', created_at DATETIME NOT NULL, INDEX IDX_E8F2B01CA429610E (poet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poet_image ADD CONSTRAINT FK_E8F2B01CA429610E FOREIGN KEY (poet_id) REFERENCES poet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poet_image DROP FOREIGN KEY FK_E8F2B01CA429610E');
        $this->addSql('DROP TABLE poem');
        $this->addSql('DROP TABLE poet');
        $this->addSql('DROP TABLE poet_image');
    }
}
