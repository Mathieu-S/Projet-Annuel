<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180419202145 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel ADD user_id INT DEFAULT NULL, ADD name VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3535ED9E7927C74 ON hotel (email)');
        $this->addSql('CREATE INDEX IDX_3535ED9A76ED395 ON hotel (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9A76ED395');
        $this->addSql('DROP INDEX UNIQ_3535ED9E7927C74 ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED9A76ED395 ON hotel');
        $this->addSql('ALTER TABLE hotel DROP user_id, DROP name, DROP address, DROP description, DROP email, DROP created_at');
    }
}
