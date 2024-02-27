<?php
if (isset($_GET['QDate'], $_GET['QNumber'])) {
    $strQDate = $_GET["QDate"];
    $strQNumber = $_GET["QNumber"];

    require('conn.php');

    $sql = "DELETE FROM queue WHERE QDate = :QDate AND QNumber = :QNumber";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':QDate', $strQDate);
    $stmt->bindParam(':QNumber', $strQNumber);

    try {
        if ($stmt->execute()) {
            echo '
                <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                <script type="text/javascript">        
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "Successfully deleted queue",
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
            echo "Error deleting record: " . implode(", ", $stmt->errorInfo());
            $message = "Fail to delete queue information.";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

    $conn = null;
}
?>
