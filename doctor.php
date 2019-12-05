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

    // if(!mysqli_query($link, "DROP TABLE VISIT;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE TEST;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE PRESCRIPTION;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE DOCTOR;")) {
    //     error(mysqli_error($link));
    // }
    // if(!mysqli_query($link, "DROP TABLE PATIENT;")) {
    //     error(mysqli_error($link));
    // }



    //Close the server
    mysqli_close($link);
?>