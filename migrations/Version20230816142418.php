<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816142418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463CA76ED395 ON nft (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D012FBE0');
        $this->addSql('DROP INDEX IDX_8D93D649D012FBE0 ON user');
        $this->addSql('ALTER TABLE user DROP n_ft_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CA76ED395');
        $this->addSql('DROP INDEX IDX_D9C7463CA76ED395 ON nft');
        $this->addSql('ALTER TABLE nft DROP user_id');
        $this->addSql('ALTER TABLE user ADD n_ft_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D012FBE0 FOREIGN KEY (n_ft_id) REFERENCES nft (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D012FBE0 ON user (n_ft_id)');
    }
}
