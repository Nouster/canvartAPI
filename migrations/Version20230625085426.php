<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230625085426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_nft (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_nft_nft (category_nft_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_E62A822AE7FBACF6 (category_nft_id), INDEX IDX_E62A822AE813668D (nft_id), PRIMARY KEY(category_nft_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_nft_nft ADD CONSTRAINT FK_E62A822AE7FBACF6 FOREIGN KEY (category_nft_id) REFERENCES category_nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_nft_nft ADD CONSTRAINT FK_E62A822AE813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_nft_nft DROP FOREIGN KEY FK_E62A822AE7FBACF6');
        $this->addSql('ALTER TABLE category_nft_nft DROP FOREIGN KEY FK_E62A822AE813668D');
        $this->addSql('DROP TABLE category_nft');
        $this->addSql('DROP TABLE category_nft_nft');
    }
}
