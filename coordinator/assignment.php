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

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='visiting'){
    $organization_id=$_POST['organization_id'];
    $visitor_id=$_POST['visitor_id'];
    $sql="insert into visiting_organization(visitor,organization) values('$visitor_id','$organization_id')";
    if ($conn->query($sql) === TRUE) {  
        //echo "<script>alert('VIsitor Assigned succcessfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}elseif($action==='delete'){
    $organization_id=$_POST['organization_id'];
    $sql="delete from organization where id = $organization_id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}elseif($action==='report'){
    $students=$_POST['students'];
    $report_supervisor=$_POST['supervisor_id'];
    $studentselector='select * from student where report_supervisor=0';
    $studentresult = mysqli_query($conn, $studentselector);
    while($row = $studentresult->fetch_assoc()) {
        $student=$row['id'];
        for($i=1;$i<=$students;$i++){
    $sql="update student set report_supervisor='$report_supervisor' where id=$student";
    if ($conn->query($sql) === TRUE) {
       
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
   
}
}
echo "<script>alert('Assignment done successfully');</script>";
}
}
//query selector for all visiting supervisors
$query = "SELECT * FROM visiting_supervisor ";
$result = mysqli_query($conn, $query);

//query selector for all organizations
$query1 = "SELECT * FROM organization ";
$result1 = mysqli_query($conn, $query1);


//query selector for all report supervisors
$query2 = "SELECT * FROM report_supervisor ";
$result2 = mysqli_query($conn, $query2);


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
                    <div class="sidebar-brand-text mx-3"><span>COORDINATOR </span></div>
                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="assignment.php"><i class="fa fa-book"></i><span>Assignment</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="students.php"><i class="fa fa-book"></i><span>Students</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="visiting.php"><i class="fa fa-book"></i><span>Visitors</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="reporters.php"><i class="fa fa-book"></i><span>Reporters</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="organizations.php"><i class="fa fa-book"></i><span>Organizations</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button></div>
                </nav>

                <div class="col">
                    <div class="card shadow mb-3">
                        <div id="wrapper">
                            <div class="d-flex flex-column" id="content-wrapper">
                                <div id="content">
                        
                                        <div class="row">
                                            <div class="col-md-6 col-xl-3 mb-4">
                                                <div class="card border-start-primary "><button class="btn btn-primary" type="button" onclick="visitForm()" id="visitButton">Visitor's Allocation</button></div>
                                            </div>
                                            <div class="col-md-6 col-xl-3 mb-4">
                                                <div class="card shadow border-start-success"><button class="btn btn-outline-primary" type="button" onclick="reportForm()" id="reportButton">Reporter's Allocation</button></div>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="row mb-3">
                            <div class="col-lg-8">      
                                <div class="row"  id="visit">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-body">
                                                <form  method="post" action="">
                                                    <input type="hidden" name="action" value="visiting" >
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Visiting Supervisor's Name</strong><br></label>
                                                                <select class="form-control" type="text" id="username" placeholder="user.name" name="visitor_id">
                                                               <?php    
                                                                while($row = $result->fetch_assoc()) {
                                                                    $name=$row['username'];
                                                                    $visitor_id=$row['id'];
                                                                    echo " <option value='$visitor_id'>$name</option>";
                                                                }         
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Organization's Name</strong><br></label>
                                                                <select class="form-control" type="text" id="username" name="organization_id">
                                                                <?php    
                                                                while($row1 = $result1->fetch_assoc()) {
                                                                    $name=$row1['name'];
                                                                    $organization_id=$row1['id'];
                                                                    echo " <option value='$organization_id'>$name</option>";
                                                                }         
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-sm" type="submit" ><i class="fa fa-upload"></i>Submit&nbsp;</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"  id="report" style="display: none;">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-body">
                                                <form  method="post" action="">
                                                <input type="hidden" name="action" value="report" >
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Reporting Supervisor's Name</strong><br></label>
                                                                <select class="form-control" type="text" id="username" name="supervisor_id">
                                                                <?php    
                                                                while($row2 = $result2->fetch_assoc()) {
                                                                    $supervisor_id=$row2['id'];
                                                                    $name=$row2['username'];
                                                                    echo " <option value='$supervisor_id'>$name</option>";
                                                                }         
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Number Of Students</strong><br></label>
                                                                <input class="form-control" type="number" id="username" placeholder="Enter number of students to be attended by a report supervisor" name="students"></input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-sm" type="submit" ><i class="fa fa-upload"></i>Submit&nbsp;</button>
                                                </form>
                                            </div>
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
        function visitForm(){
            visit.style.display="block";
            report.style.display="none";
            visitButton.classList="btn btn-primary";
            reportButton.classList="btn btn-outline-primary";
        }

        function reportForm(){
            visit.style.display="none";
            report.style.display="block";
            reportButton.classList="btn btn-primary";
            visitButton.classList="btn btn-outline-primary";
        }
    </script>
</body>

</html>