<?php

declare(strict_types=1);

namespace Alice\MoviesTutorial\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817125142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Testar conexao';
    }

    public function preUp(Schema $schema): void
    {
        parent::preUp($schema);

        $this->addSql("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->addSql("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE T_MOVIES (
            ID NUMBER NOT NULL CONSTRAINT T_MOVIES_PK PRIMARY KEY,
            NAME VARCHAR2(32) NOT NULL,
            RELEASE_DATE DATE
        )");
        $this->addSql("CREATE SEQUENCE SEQ_T_MOVIES");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE T_MOVIES");
        $this->addSql("DROP SEQUENCE SEQ_T_MOVIES");
    }
}
