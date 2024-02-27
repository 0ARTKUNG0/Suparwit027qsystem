<?php

// Always include the connection file
require 'conn.php';

// Check if QNumber is set in the POST request
if (isset($_POST['QNumber'])) {
    $sql =  "UPDATE queue 
            SET QStatus = :QStatus,
            Qdate = :Qdate
            WHERE QNumber = :QNumber";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':QStatus', $_POST['QStatus']);
    $stmt->bindParam(':QNumber', $_POST['QNumber']);
    $stmt->bindParam(':Qdate', $_POST['Qdate']);

    echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    try {
        if ($stmt->execute()) {
            echo '
                <script type="text/javascript">

                    $(document).ready(function(){
                    
                        swal({
                            title: "Success!",
                            text: "Successfully update customer information",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        }, function(){
                            window.location.href = "index.php";
                        });
                    });
                    
                </script>
                ';
        } else {
            echo 'Failed to execute the update statement.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
