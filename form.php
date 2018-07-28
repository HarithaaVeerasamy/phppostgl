<?php
$host = "host = 127.0.0.1";
$port = "port = 5432";
$dbname = "dbname = test";
$credentials = "user = postgres password=harry@123";

$db = pg_connect("$host $port $dbname $credentials");
if (!$db) {
    echo "Error : Unable to open database\n";
}
$edit = isset($_GET['edit']) ? $_GET['edit'] : "";
$delete = isset($_GET['delete']) ? $_GET['delete'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";
$name = "";
$password = "";
if ($delete == 0) {
    if ($id) {
        $query = pg_query($db, "select * from login where id=" . $id);
        while ($data = pg_fetch_array($query)) {
            $name = $data['username'];
            $password = $data['password'];
        }
    }
} else {
    $query = pg_query($db, "DELETE from login where id =" . $id);
    header('Location: form.php');
}
?>
<html>
    <head>
        <title>Add Data</title>
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="DataTables/datatables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <form action="index.php" method="post" name="form1">
            <table width="25%" border="0">
                <tr> 
                    <td>Name</td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                </tr>
                <tr> 
                    <td>Password</td>
                    <td><input type="text" name="email" value="<?= $password ?>"><input type="hidden" name="id" value="<?= $id ?>"></td>

                </tr>
                <tr> 
                    <td></td>
                    <td><input type="submit" name="Submit" value="Add"></td>
                </tr>
            </table>
        </form>
        <table style="border: 1px solid black" id="myTable"  class="table table-bordered">
            <thead style="border: 1px solid black">
            <th style="border: 1px solid black">ID</th>
            <th style='border: 1px solid black'>Name</th>
            <th style='border: 1px solid black'>Password(Email)</th>
            <th style="border: 1px solid black">Actions</th>
        </thead>
        <tbody style="border: 1px solid black">
            <?php
            $getdata = pg_query($db, "select * from login order by id ASC");
            while ($row = pg_fetch_array($getdata)) {
                echo "<tr><td style='border: 1px solid black'>" . $row['id'] . "</td><td style='border: 1px solid black'>" . $row['username'] . "</td><td style='border: 1px solid black'>" . $row['password'] . "</td><td style='border: 1px solid black'><a href='form.php?edit=1&delete=0&id=" . $row['id'] . "'><button type='button'>EDIT</button></a> &nbsp;&nbsp;<a href='form.php?edit=0&delete=1&id=" . $row['id'] . "'><button type='button'>DELETE</button></a></td></tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        $('#myTable').DataTable({
            responsive: true
        });
    </script>
</body>
</html>
