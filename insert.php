<?php
$FullName = $_POST['FullName'];
$Studentno = $_POST['Studentno'];
$Course = $_POST['Course'];
$Date = $_POST['Date'];

if (!empty($FullName) || !empty($Studentno) || !empty($Course) || !empty($Date)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "Shiela_aduana0218";
    $dbname = "voucher";

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT FullName FROM users WHERE FullName = ? Limit 1";
        $INSERT = "INSERT INTO users (FullName, Studentno, Course, Date) VALUES (?, ?, ?, ?)";

        // Prepare statement for SELECT query
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $FullName);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($FullName);
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();

            // Prepare statement for INSERT query
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sisi", $FullName, $Studentno, $Course, $Date);
            $stmt->execute();
            echo "Thank you!";
        } else {
            echo "You already got a voucher.";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>