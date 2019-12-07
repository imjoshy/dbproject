CREATE DATABASE IF NOT EXISTS project;
USE project;

DROP TABLE IF EXISTS PATIENT;
CREATE TABLE IF NOT EXISTS PATIENT(
    P_id                int             NOT NULL,
    Pnum                int             NOT NULL,
    Fname               varchar(50),
    Lname               varchar(50),
    PRIMARY KEY (P_id));

CREATE TABLE IF NOT EXISTS DOCTOR(                   
    D_id                varchar(6)      NOT NULL,
    P_id                int             NOT NULL,
    Fname               varchar(50),
    Lname               varchar(50),
    PRIMARY KEY (D_id),
    FOREIGN KEY (P_id) REFERENCES PATIENT (P_id));

CREATE TABLE IF NOT EXISTS SPECIALTY(
    S_id                int             NOT NULL,
    Sname               varchar(50)     NOT NULL,
    PRIMARY KEY (S_id));

CREATE TABLE IF NOT EXISTS DOCTORSPECIALTY(
    D_id                varchar(6)      NOT NULL,
    S_id                int             NOT NULL,
    FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id),
    FOREIGN KEY (S_id) REFERENCES SPECIALTY (S_id));

 CREATE TABLE VISIT(
    Date                varchar(25),
    P_id                int             NOT NULL,
    D_id                varchar(6)      NOT NULL,
    FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
    FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));

CREATE TABLE IF NOT EXISTS TEST(
    Date                varchar(25),
    Tname               varchar(50),
    P_id                int             NOT NULL,
    D_id                varchar(6)      NOT NULL,
    FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
    FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));

CREATE TABLE IF NOT EXISTS PRESCRIPTION(
    Date                varchar(25),
    Pname               varchar(50),
    P_id                int             NOT NULL,
    D_id                varchar(6)      NOT NULL,
    FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
    FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));

CREATE TABLE IF NOT EXISTS AUDIT(
    DFname              varchar(50)     NOT NULL,
    Action              varchar(75)     NOT NULL,
    Specialty          varchar(50),
    Date                varchar(25),
    PRIMARY KEY (Action));



            