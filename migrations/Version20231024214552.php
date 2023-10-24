<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024214552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(55) NOT NULL, email VARCHAR(55) NOT NULL, nb_books INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (ref INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, is_published TINYINT(1) NOT NULL, INDEX IDX_CBE5A331F675F31B (author_id), PRIMARY KEY(ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reader (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reader_books (reader_id INT NOT NULL, book_ref INT NOT NULL, INDEX IDX_3F9054E81717D737 (reader_id), INDEX IDX_3F9054E8E5124735 (book_ref), PRIMARY KEY(reader_id, book_ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE reader_books ADD CONSTRAINT FK_3F9054E81717D737 FOREIGN KEY (reader_id) REFERENCES reader (id)');
        $this->addSql('ALTER TABLE reader_books ADD CONSTRAINT FK_3F9054E8E5124735 FOREIGN KEY (book_ref) REFERENCES book (ref)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE reader_books DROP FOREIGN KEY FK_3F9054E81717D737');
        $this->addSql('ALTER TABLE reader_books DROP FOREIGN KEY FK_3F9054E8E5124735');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE reader');
        $this->addSql('DROP TABLE reader_books');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
