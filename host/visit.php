<?php

//initializing database connection.
include '../control/connection.php';
//session holding the coordinator logged in
session_start();
if(!isset($_SESSION['id'])){
    header('Location : index.php');
}else{
    $id=$_SESSION['id'];
}

$attending_students="style=\"display:none\"";
$signin="style=\"display:block\"";
$signin_fail="";
//query selector for all students under visiting supervisor
$query1 = "SELECT * from student";
$result1 = mysqli_query($conn, $query1);

if($_SERVER["REQUEST_METHOD"]=="POST"){
$username=$_POST['username'];
$password=$_POST['password'];
$sql = "SELECT * FROM visiting_supervisor where username='$username' and password='$password'";
$result = $conn->query($sql);
while($row1 = $result->fetch_assoc()) {
  $id=$row1['id'];
}
if ($result->num_rows > 0) {
    $attending_students="style=\"display:block\"";
    $signin="style=\"display:none\"";
    $signin_fail="";
}else{
    $signin_fail="
    <div class=\"card-header py-3\"><p class=\"text-danger fw-bold\">Couldn't find any student under this visitor !</p></div>
";
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
                <div class="container-fluid" id="signIn" <?php echo $signin?>>
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Visitor's Username</strong><br></label><input class="form-control" type="text" id="username"  name="username" placeholder="Username"></div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Password</strong><br></label><input class="form-control" type="password" id="username"  name="password" placeholder="Enter your password"></div>
                                                    </div>

                                                </div>
                                                <div class="mb-3" ><button class="btn btn-outline-primary " type="submit" ><i class="fa fa-upload" ></i>Verify&nbsp;</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow mb-3">    
                        <div class="row mb-3">
                            <div class="container-fluid">
                                <!--on signin fail shows this message -->
                              <?php echo $signin_fail?>
                                <div class="card shadow" <?php echo $attending_students?>>
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Students Under Visitation</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                            <table class="table my-0" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Student Name</th>
                                                        <th>Contact</th>
                                                        <th>Course</th>
                                                        <th>Year of study</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php    $i=1;
                                                                while($row1 = $result1->fetch_assoc()) {
                                                                    $student=$row1['id'];
                                                                    $name=$row1['name'];
                                                                    $contact=$row1['contact'];
                                                                    $course=$row1['course'];
                                                                    $year=$row1['year'];
                                                                    $visitation=$row1['visitation'];
                                                                    if($visitation==0){
                                                                        $attendance="<button class=\"btn btn-outline-primary\" type=\"button\"onclick=\"window.location.href='attend.php?student=$student'\">Attend</button>";
                                                                    }else{
                                                                        $attendance="<label class=\"text-success\" type=\"button\" >Attended</label>";
                                                                    }
                                                                    echo "
                                                                     <tr>
                                                        <td>$i</td>
                                                        <td>$name</td>
                                                        <td>$contact</td>
                                                        <td>$course</td>
                                                        <td>$year</td>
                                                        <td>$attendance</td>
                                                    </tr>
                                                                    ";
                                                                }
                                                                ?>
                                                 
                                                </tbody>
                                                <tfoot>
                                                    <tr></tr>
                                                </tfoot>
                                            </table>
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
    <script>
        function signInBtn(){
            signIn.style.display="block";
        }
        function signInDone(){
            signIn.style.display="none";
        }
       
    </script>
</body>

</html>