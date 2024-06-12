<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607174220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, publicacion_id INT NOT NULL, INDEX IDX_AC6340B3DB38439E (usuario_id), INDEX IDX_AC6340B39ACBB5E7 (publicacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39ACBB5E7 FOREIGN KEY (publicacion_id) REFERENCES publicacion (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3DB38439E');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39ACBB5E7');
        $this->addSql('DROP TABLE `like`');
    }
}
