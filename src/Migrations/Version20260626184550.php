<?php

/*
 * This file is part of the Sylius Product Document package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpertSyliusProductDocumentPlugin;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260626184550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create plugin tables for document type, document type translation and product document';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitexpert_sylius_document_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_B9424C577153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitexpert_sylius_document_type_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, locale VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_DOCTYPE_TRANS_ID (translatable_id), UNIQUE INDEX bitexpert_sylius_document_type_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitexpert_sylius_product_document (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, path VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updatedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', documentType_id INT NOT NULL, INDEX IDX_8555EDC54DA0E3EA (documentType_id), INDEX IDX_8555EDC54584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitexpert_sylius_document_type_translation ADD CONSTRAINT FK_DOCTYPE_TRANS FOREIGN KEY (translatable_id) REFERENCES bitexpert_sylius_document_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document ADD CONSTRAINT FK_8555EDC54DA0E3EA FOREIGN KEY (documentType_id) REFERENCES bitexpert_sylius_document_type (id)');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document ADD CONSTRAINT FK_8555EDC54584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE IF EXISTS bitexpert_sylius_product_document_plugin_document_type');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bitexpert_sylius_product_document_plugin_document_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, position INT NOT NULL, UNIQUE INDEX UNIQ_5041AB877153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bitexpert_sylius_document_type_translation DROP FOREIGN KEY FK_DOCTYPE_TRANS');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document DROP FOREIGN KEY FK_8555EDC54DA0E3EA');
        $this->addSql('ALTER TABLE bitexpert_sylius_product_document DROP FOREIGN KEY FK_8555EDC54584665A');
        $this->addSql('DROP TABLE bitexpert_sylius_document_type');
        $this->addSql('DROP TABLE bitexpert_sylius_document_type_translation');
        $this->addSql('DROP TABLE bitexpert_sylius_product_document');
    }
}
