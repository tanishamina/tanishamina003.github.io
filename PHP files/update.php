<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD APPLICATION</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body {
        background-color: #e0e5ec; /* A soft blue-grey shade */
    }
    .form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    @media (min-width: 768px) {
        .form-container {
            padding: 30px;
        }
    }
</style>
  </head>
  <body>
    <div class="container mt-4 mt-md-5">
        <?php 
            include "connection.php";
            
            if($_GET['update'])
            {
                $id = $_GET['update'];
                $recordID = $connection->prepare("select * from scp_subjects where id = ?");
                if(!$recordID)
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error preparing record for updating</div>";
                    exit;
                }
                $recordID->bind_param("i",$id);
                if($recordID->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record ready for updating</div>";
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                } else
                {
                      echo "<div class='alert alert-danger p-3 m-2'>Error: {$recordID->error}</div>";
                }
            }
            
            
            
            if(isset($_POST['update'])) {
                //prepare stmt to insert data
                $update = $connection->prepare("update scp_subjects set scp_item=?, object_class=?, image_path=?, containment_procedures=?,  description=? where id=?");
                $update->bind_param("sssssi", $_POST['scp_item'], $_POST['object_class'], $_POST['image_path'], $_POST['containment_procedures'],  $_POST['description'], $_POST['id']);
                
                if($update->execute()) {
                    echo "<div class='alert alert-success'>Record successfully updated</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: {$update->error}</div>";
                }
            }
        ?>
        <div class="text-center mb-4">
            <h1 class="h2 h1-md">Update record</h1>
            <p><a href="index.php" class="btn btn-outline-dark">Back to Index page</a></p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
                <div class="form-container">
                    <form method="post" action="update.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3">
                            <label for="scp_item" class="form-label">SCP item:</label>
                            <input type="text" name="scp_item" id="scp_item" placeholder="SCP_item..." class="form-control" required value="<?php echo $row['scp_item']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="object_class" class="form-label">Object class:</label>
                            <input type="text" name="object_class" id="object_class" placeholder="object class..." class="form-control" required value="<?php echo $row['object_class']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image_path" class="form-label">Image path:</label>
                            <input type="text" name="image_path" id="image_path" placeholder="images/nameofimage_path..." class="form-control"value="<?php echo $row['image_path']; ?>">
                        </div>
                        <div class="mb-3">
                            <label>Containment Procedures:</label>
                            <textarea name="containment_procedures" id="containment_procedures" class="form-control" rows="4"><?php echo $row['containment_procedures']; ?></textarea>
                        </div>
                        <div class="mb-3">
                           <label>Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4"><?php echo $row['description']; ?></textarea>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="update" value="Update Record" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
