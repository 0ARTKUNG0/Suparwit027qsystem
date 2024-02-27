<?php
require 'conn.php';
if (isset($_GET['QNumber'])) {
    $query_select = 'SELECT * FROM queue WHERE QNumber=?';
    $stmt = $conn->prepare($query_select);
    $params = array($_GET['QNumber']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $query_update = 'UPDATE queue SET Qdate=?, QStatus=? WHERE QNumber=?';
        $stmt = $conn->prepare($query_update);

        $Qdate = $_POST['Qdate'];
        $QStatus = $_POST['QStatus'];
        $QNumber = $_POST['QNumber'];

        $stmt->bindParam(1, $Qdate, PDO::PARAM_STR);
        $stmt->bindParam(2, $QStatus, PDO::PARAM_STR);
        $stmt->bindParam(3, $QNumber, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                <script type="text/javascript">        
                    $(document).ready(function(){
                        swal({
                            title: "Success!",
                            text: "Successfully updated queue information",
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
            echo 'Failed to update queue information';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Suparwit027</title>
</head>

<body>

<div class="container mt-5">
    <form action="UpdateQueue.php?QNumber=<?php echo $result['QNumber']; ?>" method="POST">
        <div class="row">
            <div class="col-md-5">
                <label for="Qdate" class="form-label">วันที่จองเข้ารับการรักษา:</label>
                <input type="text" name="Qdate" class="form-control" required value="<?php echo $result['Qdate']; ?>">
            </div>

            <div class="col-md-2">
                <label for="QNumber" class="form-label">รหัสคิว:</label>
                <input type="text" name="QNumber" class="form-control" required value="<?php echo $result['QNumber']; ?>" readonly>
            </div>

            <div class="col-md-2">
                <label for="Pid" class="form-label">รหัสบัตรประชาชน:</label>
                <input type="text" name="Pid" class="form-control" required value="<?php echo $result['pid']; ?>">
            </div>

            <div class="col-md-2">
                <label for="QStatus" class="form-label">สถานะ:</label>
                <input type="text" name="QStatus" class="form-control" required value="<?php echo $result['QStatus']; ?>">
            </div>

            <div class="col-md-1 mt-4">
                <button type="submit" name="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
            </div>
        </div>
    </form>
</div>

</body>

</html>
