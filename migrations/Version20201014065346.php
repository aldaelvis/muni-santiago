<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014065346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_salida (id INT AUTO_INCREMENT NOT NULL, salida_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_F92C24EF26A36E51 (salida_id), INDEX IDX_F92C24EF4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salida (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, total NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_salida ADD CONSTRAINT FK_F92C24EF26A36E51 FOREIGN KEY (salida_id) REFERENCES salida (id)');
        $this->addSql('ALTER TABLE detalle_salida ADD CONSTRAINT FK_F92C24EF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_salida DROP FOREIGN KEY FK_F92C24EF26A36E51');
        $this->addSql('DROP TABLE detalle_salida');
        $this->addSql('DROP TABLE salida');
    }
}
