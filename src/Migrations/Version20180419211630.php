<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180419211630 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9A76ED395');
        $this->addSql('DROP INDEX IDX_3535ED9A76ED395 ON hotel');
        $this->addSql('ALTER TABLE hotel CHANGE user_id hotelier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9FE315161 FOREIGN KEY (hotelier_id) REFERENCES hotelier (id)');
        $this->addSql('CREATE INDEX IDX_3535ED9FE315161 ON hotel (hotelier_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9FE315161');
        $this->addSql('DROP INDEX IDX_3535ED9FE315161 ON hotel');
        $this->addSql('ALTER TABLE hotel CHANGE hotelier_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3535ED9A76ED395 ON hotel (user_id)');
    }
}
