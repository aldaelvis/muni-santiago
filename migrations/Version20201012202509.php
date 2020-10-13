<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012202509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_entries (id INT AUTO_INCREMENT NOT NULL, entry_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_4A373310BA364942 (entry_id), INDEX IDX_4A3733104584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entries (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, total NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_entries ADD CONSTRAINT FK_4A373310BA364942 FOREIGN KEY (entry_id) REFERENCES entries (id)');
        $this->addSql('ALTER TABLE detail_entries ADD CONSTRAINT FK_4A3733104584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_entries DROP FOREIGN KEY FK_4A373310BA364942');
        $this->addSql('DROP TABLE detail_entries');
        $this->addSql('DROP TABLE entries');
    }
}
