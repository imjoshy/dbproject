<?php
    function error($type) {
        // die('Error: ' . $type);
        echo "Error: " . $type . "\n\n";
    }

    //Link to the server
    $link = mysqli_connect('127.0.0.1', 'root');            //By default XAMPP does not require a password when connecting root @ localhost
    if(!$link) {
        error(mysqli_error($link));
    }

    //Create the DB if it does not exist
    if(!mysqli_query($link, "USE PROJECT")) {
        mysqli_query($link, "CREATE DATABASE PROJECT");
        if(!mysqli_query($link, "USE PROJECT")) {
            error(mysqli_error($link));
        }
    }

    //Create the PATIENTs
    if(!mysqli_query($link, "SELECT 1 FROM PATIENT LIMIT 1")) {
        $patient = mysqli_query($link, "
            CREATE TABLE PATIENT(
                P_id                int             NOT NULL,
                Pnum                int             NOT NULL,
                Fname               varchar(50),
                Lname               varchar(50),
                PRIMARY KEY (P_id));
        ");
        if(!$patient) {
            error(mysqli_error($link));
        }
    }

    //Create the DOCTORs
    if(!mysqli_query($link, "SELECT 1 FROM DOCTOR LIMIT 1")) {      //To check if table exists
                                                                    //https://stackoverflow.com/questions/8829102/check-if-table-exists-without-using-select-from
        $doctor = mysqli_query($link, "
            CREATE TABLE DOCTOR(                   
                D_id                int             NOT NULL,
                P_id                int             NOT NULL,
                Fname               varchar(50),
                Lname               varchar(50),
                PRIMARY KEY (D_id),
                FOREIGN KEY (P_id) REFERENCES PATIENT (P_id));
        ");     
        if(!$doctor) {
            error(mysqli_error($link));
        }                            
    }

    //Create table SPECIALITY
    if(!mysqli_query($link, "SELECT 1 FROM SPECIALITY LIMIT 1")) {
        $speciality = mysqli_query($link, "
            CREATE TABLE SPECIALITY(
                S_id                int             NOT NULL,
                Sname               varchar(50)     NOT NULL,
                PRIMARY KEY (S_id));
        ");
    }

    //Create table DOCTORSPECIALITY
    if(!mysqli_query($link, "SELECT 1 FROM DOCTORSPECIALITY LIMIT 1")) {
        $doctorspeciality = mysqli_query($link, "
            CREATE TABLE DOCTORSPECIALITY(
                D_id                int             NOT NULL,
                S_id                int             NOT NULL,
                FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id),
                FOREIGN KEY (S_id) REFERENCES SPECIALITY (S_id));
        ");
    }

    //Create table for VISITs
    if(!mysqli_query($link, "SELECT 1 FROM VISIT LIMIT 1")) {
        $visit = mysqli_query($link, "
            CREATE TABLE VISIT(
                Date                varchar(25),
                P_id                int             NOT NULL,
                D_id                int             NOT NULL,
                FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
                FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));
        ");
        if(!$visit) {
            error(mysqli_error($link));
        }
    }

    //Create table for TESTs
    if(!mysqli_query($link, "SELECT 1 FROM TEST LIMIT 1")) {
        $test = mysqli_query($link, "
            CREATE TABLE TEST(
                Date                varchar(25),
                Tname               varchar(50),
                P_id                int             NOT NULL,
                D_id                int             NOT NULL,
                FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
                FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));
        ");
        if(!$test) {
            error(mysqli_error($link));
        }
    }

    //Create table for PRESCRIPTIONs
    if(!mysqli_query($link, "SELECT 1 FROM PRESCRIPTION LIMIT 1")) {
        $prescription = mysqli_query($link, "
            CREATE TABLE PRESCRIPTION(
                Date                varchar(25),
                Pname               varchar(50),
                P_id                int             NOT NULL,
                D_id                int             NOT NULL,
                FOREIGN KEY (P_id) REFERENCES PATIENT (P_id),
                FOREIGN KEY (D_id) REFERENCES DOCTOR (D_id));
        ");
        if(!$prescription) {
            error(mysqli_error($link));
        }
    }

    //Create table for AUDIT (#6)
    if(!mysqli_query($link, "SELECT 1 FROM AUDIT LIMIT 1")) {
        $audit = mysqli_query($link, "
            CREATE TABLE AUDIT(
                DFname              varchar(50)     NOT NULL,
                Action              varchar(75)     NOT NULL,
                Speciality          varchar(50),
                Date                varchar(25),
                PRIMARY KEY (Action));
        ");
    }


    mysqli_query($link, "
        CREATE TRIGGER insertaudits AFTER INSERT ON DOCTORSPECIALITY FOR EACH ROW
        BEGIN
            INSERT INTO AUDIT(DFname, Action, Speciality, Date) VALUES (SELECT Dname
                                                                        FROM DOCTOR
                                                                        WHERE D_id = NEW.D_id), 'INSERT', (SELECT Speciality
                                                                                                           FROM SPECIALITY
                                                                                                           WHERE S_id = NEW.S_id), CURRENT_DATE());
        END
    ");
    mysqli_query($link, "
        CREATE TRIGGER updateaudits AFTER UPDATE ON DOCTORSPECIALITY FOR EACH ROW
        BEGIN
            INSERT INTO AUDIT(DFname, Action, Speciality, Date) VALUES (SELECT Dname
                                                                        FROM DOCTOR
                                                                        WHERE D_id = NEW.D_id), 'UPDATE', (SELECT Speciality
                                                                                                           FROM SPECIALITY
                                                                                                           WHERE S_id = NEW.S_id), CURRENT_DATE());
        END
    ");
    //INSERT INTO DB
    // mysqli_query($link, "INSERT INTO ________ (_______) VALUES (____________)");

    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (12345, 1111111, 'John', 'Cena')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname) VALUES (54321, 2222222, 'Sia', 'Xxxx')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (01010, 0101010, 'Jimmy', 'John')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (22222, 3333333, 'Alan', 'Walker')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (33333, 4444444, 'John', 'Doe')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (44444, 6666666, 'Jane', 'Doe')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (55555, 5555555, 'Rob', 'Belkin')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (66666, 7777777, 'First', 'Last')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (45454, 8888888, 'Johnny', 'Doe')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (54545, 9999999, 'Janie', 'Doe')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (12121, 5123421, 'Doctor', 'Strange')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (21212, 4735634, 'Doctor', 'Phil')");
    mysqli_query($link, "INSERT INTO PATIENT(P_id, Pnum, Fname, Lname) VALUES (89456, 9999999, 'Captain', 'Teemo')");

    mysqli_query($link, "INSERT INTO SPECIALITY(S_id, Sname) VALUES (1, 'Anesthesiology')");
    mysqli_query($link, "INSERT INTO SPECIALITY(S_id, Sname) VALUES (2, 'Dermatology')");
    mysqli_query($link, "INSERT INTO SPECIALITY(S_id, Sname) VALUES (3, 'Emergency Medicine')");
    mysqli_query($link, "INSERT INTO SPECIALITY(S_id, Sname) VALUES (4, 'Pediatrics')");

    mysqli_query($link, "INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES (11111, 45454, 'Johnny', 'Doe')");
    mysqli_query($link, "INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES (22222, 54545, 'Janie', 'Doe')");
    mysqli_query($link, "INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES (33333, 12121, 'Doctor', 'Strange')");
    mysqli_query($link, "INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES (44444, 21212, 'Doctor', 'Phil')");
    mysqli_query($link, "INSERT INTO DOCTOR(D_id, P_id, Fname, Lname) VALUES (55555, 55555, 'Rob', 'Belkin')");

    mysqli_query($link, "INSERT INTO DOCTORSPECIALITY(D_id, S_id) VALUES (11111, 2);");
    mysqli_query($link, "INSERT INTO DOCTORSPECIALITY(D_id, S_id) VALUES (22222, 4);");
    mysqli_query($link, "INSERT INTO DOCTORSPECIALITY(D_id, S_id) VALUES (33333, 3);");

    mysqli_query($link, "INSERT INTO VISIT(Date, P_id, D_id) VALUES ('Nov 1', 12345, 55555);");
    mysqli_query($link, "INSERT INTO VISIT(Date, P_id, D_id) VALUES ('Nov 2', 01010, 11111);");
    mysqli_query($link, "INSERT INTO VISIT(Date, P_id, D_id) VALUES ('Nov 3', 22222, 55555);");
    mysqli_query($link, "INSERT INTO VISIT(Date, P_id, D_id) VALUES ('Nov 4', 77777, 44444);");
    mysqli_query($link, "INSERT INTO VISIT(Date, P_id, D_id) VALUES ('Nov 5', 66666, 55555);");

    mysqli_query($link, "INSERT INTO PRESCRIPTION(Date, Pname, P_id, D_id) VALUES('Nov 2', 'Panadol', 89456, 33333);");
    mysqli_query($link, "INSERT INTO PRESCRIPTION(Date, Pname, P_id, D_id) VALUES('Nov 1', 'Panadol', 12345, 44444);");
    mysqli_query($link, "INSERT INTO PRESCRIPTION(Date, Pname, P_id, D_id) VALUES('Nov 3', 'Medical Weed', 22222, 22222);");


    // To see the tables

    // $result = mysqli_query($link, "SHOW TABLES;");
    // while($row = mysqli_fetch_row($result)) {
    //     foreach ($row as $r) {
    //         echo $r . " ";
    //     }
    // }


    //***************************NUMBER 2*************************
    //Rob Belkin retiring -- create view of all of his patients' Fname, Lname, and Pnum
    mysqli_query($link, "
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
        ");
    $result = mysqli_query($link, "SELECT * FROM Belkin;");
    echo "Doctor Rob Belkin is retiring. We need to inform all his patients, and ask them to select a new doctor. For this purpose, Create a VIEW that finds the names and
    Phone numbers of all of Rob's patients.";

    echo "<table border='1'>
    <tr>
    <th>Fname</th>
    <th>Lname</th>
    <th>Pnum</th>
    </tr>";

    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Fname'] . "</td>";
        echo "<td>" . $row['Lname'] . "</td>";
        echo "<td>" . $row['Pnum'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    //***************************NUMBER 3*************************
    mysqli_query($link, "
        CREATE VIEW Panadol AS
        SELECT Fname, Lname
        FROM DOCTOR
        WHERE (D_id) IN (SELECT D_id
                        FROM PRESCRIPTION
                        WHERE Pname = 'Panadol'
                        );");

    echo "Create a view which has First Names, Last Names of all doctors who gave out prescription for Panadol.";

    $result = mysqli_query($link, "SELECT * FROM Panadol;");

    echo "<table border='1'>
    <tr>
    <th>Fname</th>
    <th>Lname</th>
    </tr>";

    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Fname'] . "</td>";
        echo "<td>" . $row['Lname'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    //***************************NUMBER 4*************************
    if(!mysqli_query($link, "
        CREATE VIEW dspec AS
        SELECT Fname, Lname, Sname
        FROM DOCTOR LEFT JOIN DOCTORSPECIALITY 
        WHERE (D_id) IN (SELECT D_id
                        FROM DOCTORSPECIALITY
                        WHERE (S_id) IN (SELECT S_id
                                        FROM SPECIALITY
                                        )
                        );
    ")) {
        error(mysqli_error($link));
    }
    echo "Create a view which shows the First Name and Last name of all doctors and their specialities.";


    $result = mysqli_query($link, "SELECT * FROM dspec;");

    echo "<table border='1'>
    <tr>
    <th>Fname</th>
    <th>Lname</th>
    <th>Sname</th>
    </tr>";

    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Fname'] . "</td>";
        echo "<td>" . $row['Lname'] . "</td>";
        echo "<td>" . $row['Sname'] . "</td>";        
        echo "</tr>";
    }
    echo "</table>";

    //***************************NUMBER 6*************************
        //TRIGGER IS ABOVE INSERTS ^^^^^^^^^^^^^^^^

    echo "Create trigger on the DoctorSpeciality so that every time a doctor specialty is updated or added, a new entry is made in the audit table. The audit table will have the following (Hint-The trigger will be on DoctorSpecialty table).
    a. Doctor’s FirstName
    b. Action(indicate update or added)
    c. Specialty
    d. Date of modification";

    echo "<table border='1'>
    <tr>
    <th>Dfname</th>
    <th>Action</th>
    <th>Speciality</th>
    <th>Date</th>
    </tr>";

    $result = mysqli_query($link, "SELECT * FROM AUDIT;");
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Dfname'] . "</td>";
        echo "<td>" . $row['Action'] . "</td>";
        echo "<td>" . $row['Speciality'] . "</td>";
        echo "<td>" . $row['Date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    //***************************NUMBER 7*************************
    echo "Create
    a. If first time backup take backup of all the tables
    b. If not the first time remove the previous backup tables and take new
    a script to do the following (Write the script for this) backups.";

    if(!mysqli_query($link, "SELECT 1 FROM VISIT_BACKUP LIMIT 1")) {
        $vbackup = mysqli_query($link, "
            CREATE TABLE VISIT_BACKUP;
            INSERT INTO VISIT_BACKUP SELECT * FROM VISIT;
        ");
        if(!$vbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for VISIT table successfully created!";
        }
    }
    else {
        $vbackup = mysqli_query($link, "
            DROP TABLE VISIT_BACKUP;
            CREATE TABLE VISIT_BACKUP;
            INSERT INTO VISIT_BACKUP SELECT * FROM VISIT;
        ");
        if(!$vbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for VISIT table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM TEST_BACKUP LIMIT 1")) {
        $tbackup = mysqli_query($link, "
            CREATE TABLE TEST_BACKUP;
            INSERT INTO TEST_BACKUP SELECT * FROM TEST;
        ");
        if(!$tbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for TEST table successfully created!";
        }
    }
    else {
        $tbackup = mysqli_query($link, "
            DROP TABLE TEST_BACKUP;
            CREATE TABLE TEST_BACKUP;
            INSERT INTO TEST_BACKUP SELECT * FROM TEST;
        ");
        if(!$tbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for TEST table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM PRESCRIPTION_BACKUP LIMIT 1")) {
        $pbackup = mysqli_query($link, "
            CREATE TABLE PRESCRIPTION_BACKUP;
            INSERT INTO PRESCRIPTION_BACKUP SELECT * FROM PRESCRIPTION;
        ");
        if(!$pbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for PRESCRIPTION table successfully created!";
        }
    }
    else {
        $pbackup = mysqli_query($link, "
            DROP TABLE PRESCRIPTION_BACKUP;
            CREATE TABLE PRESCRIPTION_BACKUP;
            INSERT INTO PRESCRIPTION_BACKUP SELECT * FROM PRESCRIPTION;
        ");
        if(!$pbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for PRESCRIPTION table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM AUDIT_BACKUP LIMIT 1")) {
        $abackup = mysqli_query($link, "
            CREATE TABLE AUDIT_BACKUP;
            INSERT INTO AUDIT_BACKUP SELECT * FROM AUDIT;
        ");
        if(!$abackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for AUDIT table successfully created!";
        }
    }
    else {
        $abackup = mysqli_query($link, "
            DROP TABLE AUDIT_BACKUP;
            CREATE TABLE AUDIT_BACKUP;
            INSERT INTO AUDIT_BACKUP SELECT * FROM AUDIT;
        ");
        if(!$abackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for AUDIT table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM DOCTORSPECIALITY_BACKUP LIMIT 1")) {
        $dsbackup = mysqli_query($link, "
            CREATE TABLE DOCTORSPECIALITY_BACKUP;
            INSERT INTO DOCTORSPECIALITY_BACKUP SELECT * FROM DOCTORSPECIALITY;
        ");
        if(!$dsbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for DOCTORSPECIALITY table successfully created!";
        }
    }
    else {
        $dsbackup = mysqli_query($link, "
            DROP TABLE DOCTORSPECIALITY_BACKUP;
            CREATE TABLE DOCTORSPECIALITY_BACKUP;
            INSERT INTO DOCTORSPECIALITY_BACKUP SELECT * FROM DOCTORSPECIALITY;
        ");
        if(!$dsbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for DOCTORSPECIALITY table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM DOCTOR_BACKUP LIMIT 1")) {
        $dbackup = mysqli_query($link, "
            CREATE TABLE DOCTOR_BACKUP;
            INSERT INTO DOCTOR_BACKUP SELECT * FROM DOCTOR;
        ");
        if(!$dbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for DOCTOR table successfully created!";
        }
    }
    else {
        $dbackup = mysqli_query($link, "
            DROP TABLE DOCTOR_BACKUP;
            CREATE TABLE DOCTOR_BACKUP;
            INSERT INTO DOCTOR_BACKUP SELECT * FROM DOCTOR;
        ");
        if(!$dbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for DOCTOR table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM SPECIALITY_BACKUP LIMIT 1")) {
        $sbackup = mysqli_query($link, "
            CREATE TABLE SPECIALITY_BACKUP;
            INSERT INTO SPECIALITY_BACKUP SELECT * FROM SPECIALITY;
        ");
        if(!$sbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for SPECIALITY table successfully created!";
        }
    }
    else {
        $sbackup = mysqli_query($link, "
            DROP TABLE SPECIALITY_BACKUP;
            CREATE TABLE SPECIALITY_BACKUP;
            INSERT INTO SPECIALITY_BACKUP SELECT * FROM SPECIALITY;
        ");
        if(!$sbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for SPECIALITY table successfully updated!";
        }
    }
    if(!mysqli_query($link, "SELECT 1 FROM PATIENT_BACKUP LIMIT 1")) {
        $pbackup = mysqli_query($link, "
            CREATE TABLE PATIENT_BACKUP;
            INSERT INTO PATIENT_BACKUP SELECT * FROM PATIENT;
        ");
        if(!$pbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for PATIENT table successfully created!";
        }
    }
    else {
        $pbackup = mysqli_query($link, "
            DROP TABLE PATIENT_BACKUP;
            CREATE TABLE PATIENT_BACKUP;
            INSERT INTO PATIENT_BACKUP SELECT * FROM PATIENT;
        ");
        if(!$pbackup) {
            error(mysqli_error($link));
        }
        else {
            echo "Backup for PATIENT table successfully updated!";
        }
    }

    //DELETE ALL TABLES
    // if(!mysqli_query($link, "DROP TABLE VISIT;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE TEST;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE PRESCRIPTION;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE AUDIT;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE DOCTORSPECIALITY;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE DOCTOR;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE SPECIALITY;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE PATIENT;")) {
    //     error(mysqli_error($link));
    // }

    //Close the server
    mysqli_close($link);
?>