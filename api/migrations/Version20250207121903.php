<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207121903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE payer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payer_identification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE payer (id INT NOT NULL, identification_id INT NOT NULL, entity_type VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41CB5B994DFE3A85 ON payer (identification_id)');
        $this->addSql('CREATE TABLE payer_identification (id INT NOT NULL, type VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE payment (id UUID NOT NULL, payer_id INT NOT NULL, transaction_amount DOUBLE PRECISION NOT NULL, installments INT NOT NULL, token VARCHAR(255) NOT NULL, payment_method_id VARCHAR(255) NOT NULL, notification_url VARCHAR(255) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D28840DC17AD9A9 ON payment (payer_id)');
        $this->addSql('COMMENT ON COLUMN payment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN payment.created_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE payer ADD CONSTRAINT FK_41CB5B994DFE3A85 FOREIGN KEY (identification_id) REFERENCES payer_identification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC17AD9A9 FOREIGN KEY (payer_id) REFERENCES payer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE payer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payer_identification_id_seq CASCADE');
        $this->addSql('ALTER TABLE payer DROP CONSTRAINT FK_41CB5B994DFE3A85');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DC17AD9A9');
        $this->addSql('DROP TABLE payer');
        $this->addSql('DROP TABLE payer_identification');
        $this->addSql('DROP TABLE payment');
    }
}
