<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201020083425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medida (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, abreviacion VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD medida_id INT DEFAULT NULL, DROP measurement');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF504B72F FOREIGN KEY (medida_id) REFERENCES medida (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF504B72F ON product (medida_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF504B72F');
        $this->addSql('DROP TABLE medida');
        $this->addSql('DROP INDEX IDX_D34A04ADF504B72F ON product');
        $this->addSql('ALTER TABLE product ADD measurement VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP medida_id');
    }
}
