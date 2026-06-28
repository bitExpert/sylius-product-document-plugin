<?php

declare(strict_types=1);

namespace BitExpertSyliusProductDocumentPlugin;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260628112557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitexpert_sylius_document_type_translation RENAME INDEX idx_doctype_trans_id TO IDX_5E83128A2C2AC5D3');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document DROP FOREIGN KEY FK_8555EDC54DA0E3EA');
        $this->addSql('DROP INDEX IDX_8555EDC54DA0E3EA ON bitexpert_sylius_product_document');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document ADD document_visibility VARCHAR(255) NOT NULL, CHANGE documentType_id document_type_id INT NOT NULL, CHANGE createdAt created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updatedAt updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document ADD CONSTRAINT FK_8555EDC561232A4F FOREIGN KEY (document_type_id) REFERENCES bitexpert_sylius_document_type (id)');
        $this->addSql('CREATE INDEX IDX_8555EDC561232A4F ON bitexpert_sylius_product_document (document_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bitexpert_sylius_document_type_translation RENAME INDEX idx_5e83128a2c2ac5d3 TO IDX_DOCTYPE_TRANS_ID');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document DROP FOREIGN KEY FK_8555EDC561232A4F');
        $this->addSql('DROP INDEX IDX_8555EDC561232A4F ON bitexpert_sylius_product_document');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document DROP document_visibility, CHANGE created_at createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updatedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE document_type_id documentType_id INT NOT NULL');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document ADD CONSTRAINT FK_8555EDC54DA0E3EA FOREIGN KEY (documentType_id) REFERENCES bitexpert_sylius_document_type (id)');
        $this->addSql('CREATE INDEX IDX_8555EDC54DA0E3EA ON bitexpert_sylius_product_document (documentType_id)');
    }
}
