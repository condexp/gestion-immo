<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720093139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property ADD price DOUBLE PRECISION DEFAULT NULL, ADD area DOUBLE PRECISION DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD adress VARCHAR(255) DEFAULT NULL, ADD postcode INT DEFAULT NULL, ADD sold TINYINT(1) DEFAULT NULL, ADD rooms INT DEFAULT NULL, ADD bedrooms INT DEFAULT NULL, ADD energy VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP price, DROP area, DROP city, DROP adress, DROP postcode, DROP sold, DROP rooms, DROP bedrooms, DROP energy');
    }
}
