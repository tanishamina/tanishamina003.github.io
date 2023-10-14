<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP-Subjects CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-image: url('images/logo.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: rgba(0, 0, 0, 0.85);
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 15px;
            z-index: 1;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(40, 167, 69, 0.5);
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .bi-plus {
            color: red;
            background: red;
            -webkit-background-clip: text;
            color: transparent;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .navbar-toggler {
                display: block;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <?php include "connection.php"; ?>

    <!-- Responsive Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="sidebar collapse d-lg-block" id="sidebarMenu">
        <a href="index.php" class="d-flex align-items-center">
            <i class="bi bi-house-door me-2"></i>
            Home
        </a>
        <?php foreach ($results as $subject) : ?>
        <a href="index.php?link=<?php echo $subject['scp_item']; ?>"><?php echo $subject['scp_item']; ?></a>
        <?php endforeach; ?>
        <a href="create.php" class="d-flex align-items-center">
            <i class="bi bi-plus me-2"></i>
            Create a new SCP-Item
        </a>
    </div>

 <div class="content">
        <?php
            if(isset($_GET['link']))
            {
                $scp_item = $_GET['link'];
                // Prepared statement
                $stmt = $connection->prepare("SELECT * FROM scp_subjects WHERE scp_item = ?");
                if(!$stmt)
                {
                    echo "<p>Error in preparing SQL statement</p>";
                    exit;
                }
                $stmt->bind_param("s", $scp_item);
                
                if($stmt->execute())
                {
                    $result = $stmt->get_result();
                    
                    if($result->num_rows > 0)
                    {
                        $subject = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" . $subject['id'];
                        $delete = "index.php?delete=" . $subject['id'];

                        echo "
                            <div class='card card-body shadow mb-3'>
                                <h2 class='card-title'>SCP ITEM: {$subject['scp_item']} | Object Class: {$subject['object_class']}</h2>
                                <h5>Description:</h5>
                                <p>{$subject['description']}</p>
                                <h5>Containment Procedures:</h5>
                                <p>{$subject['containment_procedures']}</p>
                                <p class='text-center'>
                                    <img src='{$subject['image_path']}' alt='Image for SCP-{$subject['scp_item']}' class='img-fluid'>
                                </p>
                                <p>
                                    <a href='{$update}' class='btn btn-info'>Update Record</a>
                                    <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                                </p>
                            </div>
                        ";
                    }
                    else
                    {
                        echo "<p>No record found for SCP-Item: {$subject['scp_item']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing the statement, {$stmt->error}</p>";
                }
            }
          else
                {
                    echo "
                    <div class='card card-body shadow mb-3 text-center'>
                        <h2 class='card-title'>Welcome to the SCP-Subjects CRUD Application</h2>
                        <p>Explore and manage SCP subjects with ease.</p>
                    </div>";
                }

            // Delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("DELETE FROM scp_subjects WHERE id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Recorded Deleted...</div>";
                }
                else
                {
                     echo "<div class='alert alert-danger'>Error deleting record {$delete->error}.</div>";
                }
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
