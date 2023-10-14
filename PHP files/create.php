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
            if(isset($_POST['submit'])) {
                //prepare stmt to insert data
                $insert = $connection->prepare("insert into scp_subjects(scp_item,object_class,image_path,containment_procedures,description) value(?,?,?,?,?) ");
                $insert->bind_param("sssss",$_POST['scp_item'],$_POST['object_class'],$_POST['image_path'],$_POST['containment_procedures'],$_POST['description']);
                if($insert->execute()) {
                    echo "<div class='alert alert-success'>Record successfully created</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: {$insert->error}</div>";
                }
            }
        ?>
        <div class="text-center mb-4">
            <h1 class="h2 h1-md">Create a new record</h1>
            <p><a href="index.php" class="btn btn-outline-dark">Back to Index page</a></p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 col-md-10 offset-lg-2 offset-md-1">
                <div class="form-container">
                    <form method="post" action="create.php">
                        <div class="mb-3">
                            <label for="scp_item" class="form-label">Enter SCP item:</label>
                            <input type="text" name="scp_item" id="scp_item" placeholder="SCP_item..." class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="object_class" class="form-label">Enter object class:</label>
                            <input type="text" name="object_class" id="object_class" placeholder="object class..." class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="image_path" class="form-label">Enter image path:</label>
                            <input type="text" name="image_path" id="image_path" placeholder="images/nameofimage_path..." class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="containment_procedures" class="form-label">Enter Containment Procedures:</label>
                            <textarea name="containment_procedures" id="containment_procedures" class="form-control" rows="4">Containment Procedures here:</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Enter description:</label>
                            <textarea name="description" id="description" class="form-control" rows="4">Enter description here:</textarea>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="submit" value="Create Record" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
