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
                Pnum                varchar(20)     NOT NULL,
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
    
    // //Create the PATIENTs
    // if(!mysqli_query($link, "SELECT 1 FROM PATIENT LIMIT 1")) {
    //     $patient = mysqli_query($link, "
    //         CREATE TABLE PATIENT(
    //             P_id                int             NOT NULL,
    //             Pnum                int,
    //             Fname               varchar(50),
    //             Lname               varchar(50),
    //             PRIMARY KEY (P_id));
    //     ");
    //     if(!$patient) {
    //         error(mysqli_error($link));
    //     }
    // }

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

    //To see the tables
    // $result = mysqli_query($link, "SHOW TABLES;");
    // while($row = mysqli_fetch_row($result)) {
    //     foreach ($row as $r) {
    //         echo $r . " ";
    //     }
    // }

    //Close the server
    mysqli_close($link);
?>