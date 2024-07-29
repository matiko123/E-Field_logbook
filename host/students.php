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

//set time when after 08:00am the sign in session ends
$current_time=date('H:i');
$start_time='06:00';
$end_time='08:30';
$refresh_time='00:00';


if($current_time>=$refresh_time){
    $sql="update student set logbook=1 ";
    $conn->query($sql);  
 }

    if($current_time>=$start_time && $current_time<=$end_time){
       $session="<button class=\"btn btn-outline-primary \" type=\"submit\" onclick=\"signInDone()\"><i class=\"fa fa-upload\" ></i>Sign In&nbsp;</button>";
       $blocking="style=\"display:block\"";
    }else{
        $session="<label class=\"text-danger\"><i>Sign in timeout!</i></label>";
        $blocking="style=\"display:none\"";
    }

//visitation assignment
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='attend'){
    $student=$_POST['index'];
    $password=$_POST['password'];
    $sql="update student set logbook=0 where index_no='$student'and password='$password'";
    if ($conn->query($sql) === TRUE) {  
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}if($action==='timer'){
    $session="<button class=\"btn btn-outline-primary \" type=\"submit\" onclick=\"signInDone()\"><i class=\"fa fa-upload\" ></i>Sign In&nbsp;</button>";
    $blocking="style=\"display:block\"";
}

}


//query selector for all students under host supervisor
$query1 = "SELECT * from student";
$result1 = mysqli_query($conn, $query1);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!--refresh time for the page to see a time within sign in range -->
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
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="visit.php"><i class="fa fa-book"></i><span>Supervisor Visitation</span></a></li>
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
                        <h3 class="text-dark mb-0">Dashboard </h3>
                        <form method="post">
                            <input type="hidden" name="action" value="timer"> 
                        <button class="btn btn-outline-danger" type="submit"> Allow Sign in </button>
                      </form>
                    </div>
                </div>
                <div class="container-fluid" style="display: none;" id="signIn">
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-body">
                                            <form method="post">
                                              <input type="hidden" name="action" value="attend"> 
                                                <div class="row" <?php echo $blocking ?>>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Registration Number (Student Name)</strong><br></label><input class="form-control" type="text" id="username"  name="index" placeholder="IMC/BIT/11223344"></div>
                                                    </div>

                                                </div>
                                                <div class="row"  <?php echo $blocking ?>>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Password</strong><br></label><input class="form-control" type="password" id="username"  name="password" placeholder="Enter your password"></div>
                                                    </div>

                                                </div>
                                                <div class="mb-3" ><?php echo $session ?></div>
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
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Students Under Supervision</p>
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
                                                        <th>Allow Signing in</th>
                                                        <th>View Logbook</th>
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
                                                                    $logbook=$row1['logbook'];
                                                                if($logbook==1){
                                                                    $logbook="<button class=\"btn btn-outline-primary\" type=\"button\" onclick=\"signInBtn()\">Allow</button>";
                                                                }else{
                                                                    $logbook="<label class=\"text-success\" type=\"button\" >Signed In</label>";
                                                                }
                                                                    echo " 
                                                                 <tr>
                                                       <td>$i</td>
                                                        <td>$name</td>
                                                        <td>$contact</td>
                                                        <td>$course</td>
                                                        <td>$year</td>
                                                        <td>$logbook</td>
                                                        <td><button class=\"btn btn-outline-success\" type=\"button\" onclick=\"window.location.href='documents.php?student=$student'\"> View</button></td>
                                                    </tr>
                                                                    ";
                                                                    $i++;
                                                                }         
                                                                ?>
                                                       
                                                    </tr>
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