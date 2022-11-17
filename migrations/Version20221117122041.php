<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117122041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordered (id INT AUTO_INCREMENT NOT NULL, user_order_id INT NOT NULL, dish_id INT NOT NULL, created_ad DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_C3121F996D128938 (user_order_id), INDEX IDX_C3121F99148EB0CB (dish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F996D128938 FOREIGN KEY (user_order_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_C3121F99148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F996D128938');
        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_C3121F99148EB0CB');
        $this->addSql('DROP TABLE ordered');
    }
}
