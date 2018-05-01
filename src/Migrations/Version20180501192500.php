<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180501192500 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bedrooms_options DROP FOREIGN KEY FK_D9B8F4E0A7C41D6F');
        $this->addSql('CREATE TABLE optional_equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP INDEX IDX_D9B8F4E0A7C41D6F ON bedrooms_options');
        $this->addSql('ALTER TABLE bedrooms_options DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE bedrooms_options CHANGE option_id optional_equipment_id INT NOT NULL');
        $this->addSql('ALTER TABLE bedrooms_options ADD CONSTRAINT FK_D9B8F4E0DA8D57F0 FOREIGN KEY (optional_equipment_id) REFERENCES optional_equipment (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D9B8F4E0DA8D57F0 ON bedrooms_options (optional_equipment_id)');
        $this->addSql('ALTER TABLE bedrooms_options ADD PRIMARY KEY (bed_room_id, optional_equipment_id)');
        $this->addSql('ALTER TABLE hotelier CHANGE enable_account enable_account TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bedrooms_options DROP FOREIGN KEY FK_D9B8F4E0DA8D57F0');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE optional_equipment');
        $this->addSql('DROP INDEX IDX_D9B8F4E0DA8D57F0 ON bedrooms_options');
        $this->addSql('ALTER TABLE bedrooms_options DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE bedrooms_options CHANGE optional_equipment_id option_id INT NOT NULL');
        $this->addSql('ALTER TABLE bedrooms_options ADD CONSTRAINT FK_D9B8F4E0A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D9B8F4E0A7C41D6F ON bedrooms_options (option_id)');
        $this->addSql('ALTER TABLE bedrooms_options ADD PRIMARY KEY (bed_room_id, option_id)');
        $this->addSql('ALTER TABLE hotelier CHANGE enable_account enable_account TINYINT(1) DEFAULT \'0\'');
    }
}
