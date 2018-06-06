<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180605220921 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, type_account VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_hotels (user_id INT NOT NULL, hotel_id INT NOT NULL, INDEX IDX_EBE578B5A76ED395 (user_id), INDEX IDX_EBE578B53243BB18 (hotel_id), PRIMARY KEY(user_id, hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotelier (id INT NOT NULL, siren VARCHAR(255) NOT NULL, enable_account TINYINT(1) DEFAULT \'0\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, INDEX IDX_CD1DE18A98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, INDEX IDX_2D5B0234AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, department_id INT DEFAULT NULL, city_id INT DEFAULT NULL, postal_code_id INT DEFAULT NULL, hotelier_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3535ED998260155 (region_id), INDEX IDX_3535ED9AE80F5DF (department_id), INDEX IDX_3535ED98BAC62AF (city_id), INDEX IDX_3535ED9BDBA6A61 (postal_code_id), INDEX IDX_3535ED9FE315161 (hotelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bed_room (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, availability TINYINT(1) NOT NULL, nb_of_persons_max INT NOT NULL, INDEX IDX_549F803C3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bedrooms_options (bed_room_id INT NOT NULL, optional_equipment_id INT NOT NULL, INDEX IDX_D9B8F4E01003CF0E (bed_room_id), INDEX IDX_D9B8F4E0DA8D57F0 (optional_equipment_id), PRIMARY KEY(bed_room_id, optional_equipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_4C62E638F624B39D (sender_id), INDEX IDX_4C62E638CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, bedroom_id INT DEFAULT NULL, uri VARCHAR(255) NOT NULL, INDEX IDX_C53D045F3243BB18 (hotel_id), INDEX IDX_C53D045FBDB6797C (bedroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optional_equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postal_code (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, code VARCHAR(5) NOT NULL, INDEX IDX_EA98E3768BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, bedroom_id INT DEFAULT NULL, user_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, start_date DATE NOT NULL, final_date DATE NOT NULL, nb_of_persons INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_42C84955BDB6797C (bedroom_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_hotels ADD CONSTRAINT FK_EBE578B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_hotels ADD CONSTRAINT FK_EBE578B53243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotelier ADD CONSTRAINT FK_4AC4D867BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED98BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9FE315161 FOREIGN KEY (hotelier_id) REFERENCES hotelier (id)');
        $this->addSql('ALTER TABLE bed_room ADD CONSTRAINT FK_549F803C3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bedrooms_options ADD CONSTRAINT FK_D9B8F4E01003CF0E FOREIGN KEY (bed_room_id) REFERENCES bed_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bedrooms_options ADD CONSTRAINT FK_D9B8F4E0DA8D57F0 FOREIGN KEY (optional_equipment_id) REFERENCES optional_equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FBDB6797C FOREIGN KEY (bedroom_id) REFERENCES bed_room (id)');
        $this->addSql('ALTER TABLE postal_code ADD CONSTRAINT FK_EA98E3768BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955BDB6797C FOREIGN KEY (bedroom_id) REFERENCES bed_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_hotels DROP FOREIGN KEY FK_EBE578B5A76ED395');
        $this->addSql('ALTER TABLE hotelier DROP FOREIGN KEY FK_4AC4D867BF396750');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638F624B39D');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638CD53EDB6');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9FE315161');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A98260155');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED998260155');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234AE80F5DF');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9AE80F5DF');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED98BAC62AF');
        $this->addSql('ALTER TABLE postal_code DROP FOREIGN KEY FK_EA98E3768BAC62AF');
        $this->addSql('ALTER TABLE users_hotels DROP FOREIGN KEY FK_EBE578B53243BB18');
        $this->addSql('ALTER TABLE bed_room DROP FOREIGN KEY FK_549F803C3243BB18');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3243BB18');
        $this->addSql('ALTER TABLE bedrooms_options DROP FOREIGN KEY FK_D9B8F4E01003CF0E');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FBDB6797C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955BDB6797C');
        $this->addSql('ALTER TABLE bedrooms_options DROP FOREIGN KEY FK_D9B8F4E0DA8D57F0');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9BDBA6A61');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users_hotels');
        $this->addSql('DROP TABLE hotelier');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE bed_room');
        $this->addSql('DROP TABLE bedrooms_options');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE optional_equipment');
        $this->addSql('DROP TABLE postal_code');
        $this->addSql('DROP TABLE reservation');
    }
}
