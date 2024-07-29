<?php
$student=$_GET['student'];
//initializing database connection.
include '../control/connection.php';
session_start();
if(!isset($_SESSION['id'])){
    header('Location : index.php');
}else{
    $visitor=$_SESSION['id'];
}

//query selector for all students under visiting supervisor
$query1 = "SELECT * from student where id=$student";
$result1 = mysqli_query($conn, $query1);
while($row1 = $result1->fetch_assoc()) {
    $name=$row1['name'];
  }
  if($_SERVER["REQUEST_METHOD"]=="POST" ){
    $comments=mysqli_real_escape_string($conn,$_POST['comments']); 
            $sql="insert into visiting_supervisor_comments (visitor,student,comments) values('$visitor','$student','$comments')";
            if ($conn->query($sql) === TRUE) {
                $sql1="update student set visitation=1 where id=$student";
                if ($conn->query($sql1) === TRUE) {
                  echo "<script>window.location.href='visit.php';</script>";
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>E_logbook</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-text mx-3"><span>Host Supervisor</span></div>

                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link " href="students.php"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="visit.php"><i class="fa fa-book"></i><span>Supervisor Visitation</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button></div>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3>
                    </div>
                </div>
                <div class="container-fluid"  id="signIn">
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Student's Name : <?php echo $name ?></strong><br></label>
                                                            <textarea class="form-control" type="text" id="username"  name="comments" placeholder="Please enter your comments based on student's answers from your assessment" style="height: 3cm;"></textarea></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3" ><button class="btn btn-outline-primary " type="submit"><i class="fa fa-upload" ></i>Submit&nbsp;</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © ifmstudents 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/theme.js"></script>

</body>

</html>