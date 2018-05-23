<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180523220500 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_3535ED9E7927C74 ON hotel');
        $this->addSql('ALTER TABLE hotel ADD region_id INT DEFAULT NULL, ADD department_id INT DEFAULT NULL, ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED98BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_3535ED998260155 ON hotel (region_id)');
        $this->addSql('CREATE INDEX IDX_3535ED9AE80F5DF ON hotel (department_id)');
        $this->addSql('CREATE INDEX IDX_3535ED98BAC62AF ON hotel (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED998260155');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9AE80F5DF');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED98BAC62AF');
        $this->addSql('DROP INDEX IDX_3535ED998260155 ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED9AE80F5DF ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED98BAC62AF ON hotel');
        $this->addSql('ALTER TABLE hotel DROP region_id, DROP department_id, DROP city_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3535ED9E7927C74 ON hotel (email)');
    }
}
