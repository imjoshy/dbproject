USE project;

INSERT INTO PATIENT (P_id, Pnum, Fname, Lname) VALUES
    (12345, 1111111, 'John', 'Cena'),
    (01010, 0101010, 'Jimmy', 'John'),
    (22222, 3333333, 'Alan', 'Walker'),
    (33333, 4444444, 'John', 'Doe'),
    (44444, 6666666, 'Jane', 'Doe'),
    (55555, 5555555, 'Rob', 'Belkin'),
    (66666, 7777777, 'First', 'Last'),
    (45454, 8888888, 'Johnny', 'Doe'),
    (54545, 9999999, 'Janie', 'Doe'),
    (12121, 5123421, 'Doctor', 'Strange'),
    (21212, 4735634, 'Doctor', 'Phil'),
    (89456, 9999999, 'Captain', 'Teemo');
INSERT INTO PATIENT (P_id, Pnum, Fname) VALUES (54321, 2222222, 'Sia');

INSERT INTO SPECIALTY(S_id, Sname) VALUES 
    (1, 'Anesthesiology'),
    (2, 'Dermatology'),
    (3, 'Emergency Medicine'),
    (4, 'Pediatrics');

INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES 
    ('JD1111', 45454, 'Johnny', 'Doe'),
    ('JD2222', 54545, 'Janie', 'Doe'),
    ('DS3333', 12121, 'Doctor', 'Strange'),
    ('DP4444', 21212, 'Doctor', 'Phil'),
    ('RB5555', 55555, 'Rob', 'Belkin');

INSERT INTO DOCTORSPECIALTY(D_id, S_id) VALUES 
    ('JD1111', 2),
    ('JD2222', 4),
    ('DS3333', 3);

INSERT INTO VISIT(Date, P_id, D_id) VALUES
    ('Nov 1', 89456, 'RB5555'),
    ('Nov 2', 01010, 'JD1111'),
    ('Nov 3', 22222, 'RB5555'),
    ('Nov 4', 89456, 'DP4444'),
    ('Nov 5', 12345, 'RB5555');

INSERT INTO PRESCRIPTION(Date, Pname, P_id, D_id) VALUES
    ('Nov 2', 'Panadol', 89456, 'DS3333'),
    ('Nov 1', 'Panadol', 12345, 'DP4444'),
    ('Nov 3', 'Medical Weed', 22222, 'JD2222'),
    ('Nov 4', 'Mushrooms', 89456, 'DS3333');

CREATE VIEW Belkin AS
    SELECT Fname, Lname, Pnum
    FROM PATIENT
    WHERE (P_id) IN (SELECT P_id
                    FROM VISIT
                    WHERE (D_id) IN (SELECT D_id
                                    FROM DOCTOR
                                    WHERE Fname = 'Rob' AND Lname = 'Belkin'
                                    )
                    );

CREATE VIEW Panadol AS
    SELECT Fname, Lname
    FROM DOCTOR
    WHERE (D_id) IN (SELECT D_id
                    FROM PRESCRIPTION
                    WHERE Pname = 'Panadol'
                    );

CREATE VIEW dspec AS
        SELECT DISTINCT Fname, Lname, Sname
        FROM DOCTOR LEFT JOIN DOCTORSPECIALTY
        ON DOCTOR.D_id = DOCTORSPECIALTY.D_id
        LEFT JOIN SPECIALTY
        ON SPECIALTY.S_id = DOCTORSPECIALTY.S_id
        WHERE Sname IS NOT NULL;

CREATE VIEW alldspec AS
    SELECT DISTINCT Fname, Lname, Sname
    FROM DOCTOR LEFT JOIN DOCTORSPECIALTY
    ON DOCTOR.D_id = DOCTORSPECIALTY.D_id
    LEFT JOIN SPECIALTY
    ON SPECIALTY.S_id = DOCTORSPECIALTY.S_id;