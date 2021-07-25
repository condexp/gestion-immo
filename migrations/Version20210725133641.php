<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210725133641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property ADD propertytype_id INT NOT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE4208046C FOREIGN KEY (propertytype_id) REFERENCES property_type (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDE4208046C ON property (propertytype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE4208046C');
        $this->addSql('DROP INDEX IDX_8BF21CDE4208046C ON property');
        $this->addSql('ALTER TABLE property DROP propertytype_id');
    }
}
