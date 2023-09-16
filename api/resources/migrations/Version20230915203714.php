<?php

declare(strict_types=1);

namespace Alice\MoviesTutorial\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915203714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function preUp(Schema $schema): void
    {
        parent::preUp($schema);

        $this->addSql("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->addSql("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE T_MEMBERS(
            ID NUMBER NOT NULL CONSTRAINT T_MEMBERS_PK PRIMARY KEY,
            NAME VARCHAR2(50) NOT NULL,
            EMAIL VARCHAR2(50) NOT NULL
        )");
        $this->addSql("CREATE SEQUENCE SEQ_T_MEMBERS");
        $this->addSql("CREATE TABLE T_RATINGS (
            ID NUMBER NOT NULL CONSTRAINT T_RATINGS_PK PRIMARY KEY,
            RATING NUMBER NOT NULL,
            MOVIE_ID NUMBER NOT NULL,
            MEMBER_ID NUMBER NOT NULL,
            FOREIGN KEY (MOVIE_ID) REFERENCES T_MOVIES(ID),
            FOREIGN KEY (MEMBER_ID) REFERENCES T_MEMBERS(ID)
        )");
        $this->addSql("CREATE SEQUENCE SEQ_T_RATINGS");
     
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE T_RATINGS");
        $this->addSql("DROP SEQUENCE SEQ_T_RATINGS");
        $this->addSql("DROP TABLE T_MEMBERS");
        $this->addSql("DROP SEQUENCE SEQ_T_MEMBERS");
    }
}
