<?php
    function error($line, $type) {
        // die('Error: ' . $type);
        echo nl2br("<b><i>Line $line, Error: $type</i></b>\n\n");
    }

    //Link to the server
    $db = new PDO('mysql:host=localhost', 'root', '');
    $link = mysqli_connect('127.0.0.1', 'root');            //By default XAMPP does not require a password when connecting root @ localhost
    if(!$link) {
        error(__LINE__, mysqli_error($link));
    }
    if(!mysqli_query($link, "USE project;")) {
        $sql = file_get_contents('project1.sql');
        $db->exec($sql);
        $sql = file_get_contents('project1queries.sql');
        $db->exec($sql);
    }
    mysqli_query($link, "USE project;");

    echo "<h4>Doctor Rob Belkin is retiring. We need to inform all his patients, and ask them to select a new doctor. For this purpose, Create a VIEW that finds the names and
    Phone numbers of all of Rob's patients.</h4>";
    $result = mysqli_query($link, "SELECT * FROM Belkin;");
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
    echo "<h4>Create a view which has First Names, Last Names of all doctors who gave out prescription for Panadol.</h4>";
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

    echo "<h4>Create a view which shows the First Name and Last name of all doctors and their specialities.</h4>";
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

    //***************************NUMBER 5*************************
    echo "<h4>Modify the view created in Q4 to show the First Name and Last name of all doctors and their specialties ALSO include doctors who DO NOT have any specialty.</h4>";
    $result = mysqli_query($link, "SELECT * FROM alldspec;");
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
    echo "<h4>Create trigger on the DOCTORSPECIALTY so that every time a doctor specialty is updated or added, a new entry is made in the audit table. The audit table will have the following (Hint-The trigger will be on DoctorSpecialty table).
    a. Doctor’s FirstName
    b. Action(indicate update or added)
    c. Specialty
    d. Date of modification</h4>";

    echo "<table border='1'>
    <tr>
    <th>Dfname</th>
    <th>Action</th>
    <th>Specialty</th>
    <th>Date</th>
    </tr>";

    $result = mysqli_query($link, "SELECT * FROM AUDIT;");
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Dfname'] . "</td>";
        echo "<td>" . $row['Action'] . "</td>";
        echo "<td>" . $row['Specialty'] . "</td>";
        echo "<td>" . $row['Date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    //***************************NUMBER 7*************************
    echo "<h4>Create
    a. If first time backup take backup of all the tables
    b. If not the first time remove the previous backup tables and take new
    a script to do the following (Write the script for this) backups.</h4>";

    if(!mysqli_query($link, "SELECT 1 FROM VISIT_BACKUP LIMIT 1")) {
        $vbackup = mysqli_query($link, "
            CREATE TABLE VISIT_BACKUP AS SELECT * FROM VISIT;
        ");
        echo "<h5>Backup for VISIT table successfully created!</h5>";
    }
    else {
        $vbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS VISIT_BACKUP;
            CREATE TABLE VISIT_BACKUP AS SELECT * FROM VISIT;
        ");
        echo "<h5>Backup for VISIT table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM TEST_BACKUP LIMIT 1")) {
        $tbackup = mysqli_query($link, "
            CREATE TABLE TEST_BACKUP AS SELECT * FROM TEST;
        ");
        echo "<h5>Backup for TEST table successfully created!</h5>";
    }
    else {
        $tbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS TEST_BACKUP;
            CREATE TABLE TEST_BACKUP AS SELECT * FROM TEST;
        ");
        echo "<h5>Backup for TEST table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM PRESCRIPTION_BACKUP LIMIT 1")) {
        $pbackup = mysqli_query($link, "
            CREATE TABLE PRESCRIPTION_BACKUP AS SELECT * FROM PRESCRIPTION;
        ");
        echo "<h5>Backup for PRESCRIPTION table successfully created!</h5>";
    }
    else {
        $pbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS PRESCRIPTION_BACKUP;
            CREATE TABLE PRESCRIPTION_BACKUP AS SELECT * FROM PRESCRIPTION;
        ");
        echo "<h5>Backup for PRESCRIPTION table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM AUDIT_BACKUP LIMIT 1")) {
        $abackup = mysqli_query($link, "
            CREATE TABLE AUDIT_BACKUP AS SELECT * FROM AUDIT;
        ");
        echo "<h5>Backup for AUDIT table successfully created!</h5>";

    }
    else {
        $abackup = mysqli_query($link, "
            DROP TABLE IF EXISTS AUDIT_BACKUP;
            CREATE TABLE AUDIT_BACKUP AS SELECT * FROM AUDIT;
        ");
        echo "<h5>Backup for AUDIT table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM DOCTORSPECIALTY_BACKUP LIMIT 1")) {
        $dsbackup = mysqli_query($link, "
            CREATE TABLE DOCTORSPECIALTY_BACKUP AS SELECT * FROM DOCTORSPECIALTY;
        ");
        echo "<h5>Backup for DOCTORSPECIALTY table successfully created!</h5>";
    }
    else {
        $dsbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS DOCTORSPECIALTY_BACKUP;
            CREATE TABLE DOCTORSPECIALTY_BACKUP AS SELECT * FROM DOCTORSPECIALTY;
        ");
        echo "<h5>Backup for DOCTORSPECIALTY table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM DOCTOR_BACKUP LIMIT 1")) {
        $dbackup = mysqli_query($link, "
            CREATE TABLE DOCTOR_BACKUP AS SELECT * FROM DOCTOR;
        ");
        echo "<h5>Backup for DOCTOR table successfully created!</h5>";
    }
    else {
        $dbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS DOCTOR_BACKUP;
            CREATE TABLE DOCTOR_BACKUP AS SELECT * FROM DOCTOR;
        ");
        echo "<h5>Backup for DOCTOR table successfully updated!</h5>";
    }
    if(!mysqli_query($link, "SELECT 1 FROM SPECIALTY_BACKUP LIMIT 1")) {
        $sbackup = mysqli_query($link, "
            CREATE TABLE SPECIALTY_BACKUP AS SELECT * FROM SPECIALTY;
        ");
            echo "<h5>Backup for SPECIALTY table successfully created!</h5>";
    }
    else {
        $sbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS SPECIALTY_BACKUP;
            CREATE TABLE SPECIALTY_BACKUP AS SELECT * FROM SPECIALTY;
        ");
        echo "<h5>Backup for SPECIALTY table successfully updated!</h5>";

    }
    if(!mysqli_query($link, "SELECT 1 FROM PATIENT_BACKUP LIMIT 1")) {
        $pbackup = mysqli_query($link, "
            CREATE TABLE PATIENT_BACKUP AS SELECT * FROM PATIENT;
        ");
        echo "<h5>Backup for PATIENT table successfully created!</h5>";
    }
    else {
        $pbackup = mysqli_query($link, "
            DROP TABLE IF EXISTS PATIENT_BACKUP;
            CREATE TABLE PATIENT_BACKUP AS SELECT * FROM PATIENT;
        ");
        echo "<h5>Backup for PATIENT table successfully updated!</h5>";

    }

    //TO CHECK BACKUP TABLE
    // echo "<h4>DOCTOR BACKUP TABLE</h4>";
    // $result = mysqli_query($link, "SELECT * FROM DOCTOR_BACKUP;");
    // echo "<table border='1'>
    // <tr>
    // <th>Fname</th>
    // <th>Lname</th>
    // <th>D_id</th>
    // </tr>";

    // while($row = mysqli_fetch_array($result)) {
    //     echo "<tr>";
    //     echo "<td>" . $row['Fname'] . "</td>";
    //     echo "<td>" . $row['Lname'] . "</td>";
    //     echo "<td>" . $row['D_id'] . "</td>";        
    //     echo "</tr>";
    // }
    // echo "</table>";

    //Close the server
    mysqli_close($link);
?>