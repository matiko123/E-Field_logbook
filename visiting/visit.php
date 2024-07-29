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

//visitation assignment
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $visitation_id=$_POST['visiting_id'];
    $date=$_POST['date'];
    $sql="update visiting_organization set visitation= '$date' where id=$visitation_id";
    if ($conn->query($sql) === TRUE) {  
        echo "<script>alert('Vssitation Assigned succcessfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

//query selector for all students under allocation
$query1 = "SELECT count(field_selection.id) as students,organization.name,visiting_organization.visitation,field_selection.location from  student inner join field_selection on field_selection.student=student.id inner join organization on organization.id=field_selection.organization inner join visiting_organization on visiting_organization.organization=field_selection.organization  where visiting_organization.visitor=$id and field_selection.verification=1";
$result1 = mysqli_query($conn, $query1);

//query selector for organization join visiting supervisors
$query2 = "SELECT visiting_organization.id as identifier,organization.name from organization inner join visiting_organization on visiting_organization.organization=organization.id where visiting_organization.visitor=$id";
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
                    <div class="sidebar-brand-icon ">Host Sup</div>

                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link " href="students.php"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-book"></i><span>Supervisor Visitation</span></a></li>
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
                        <h3 class="text-dark mb-0">Students Visitation</h3>
                    </div>

                    <div class="col-lg-8">
                               
                               <div class="row" id="application">
                                   <div class="col">
                                       <div class="card shadow mb-3">
                                           <div class="card-body">
                                               <form method="post" action="">
                                                   <input type="hidden" name="action" value="register">
                                                   <div class="row">
                                                       <div class="col">
                                                        <div class="row">
                                                            <form method="post">
                                                                <div class="col-md-6">
                                                                <label class="form-label" for="username"><strong>Select Organization</strong><hr>
                                                                <select class="form-control" type="text" id="username" name="visiting_id">
                                                                <?php    
                                                                while($row2 = $result2->fetch_assoc()) {
                                                                    $name=$row2['name'];
                                                                    $visiting_id=$row2['identifier'];
                                                                    echo " <option value='$visiting_id'>$name</option>";
                                                                }         
                                                                ?>
                                                                </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                <label class="form-label" for="username"><strong>Set visitation date</strong><hr>
                                                                    <input class="form-control" type="date" id="username" placeholder="organization's date" name="date" required>
                                                                </div>
                                                                </div>
                                                                 <button class="btn btn-primary btn-sm" type="submit" ><i class="fa fa-upload"></i>Submit&nbsp;</button>
                                                            </form>
                                                       </div>
                                                     
                                                   </div>
                                                  
                                               </form>
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
                                                        <th>Organization Name</th>
                                                        <th>Location</th>
                                                        <th>Number of students</th>
                                                        <th>Visitation date</th>
                                                    </tr>
                                            
                                                    
                                                </thead>
                                                <tbody>
                                                <?php    $i=1;
                                                                while($row1 = $result1->fetch_assoc()) {
                                                                    $name=$row1['name'];
                                                                    $location=$row1['location'];
                                                                    $students=$row1['students'];
                                                                    $visitation=$row1['visitation'];

                                                                if($visitation==''){
                                                                    $visitation="<label class='text-danger'><i>No visitation set</i></label>";
                                                                }
                                                                    echo " 
                                                                 <tr>
                                                        <td>$i</td>
                                                        <td>$name</td>
                                                        <td>$location</td>
                                                        <td>$students</td>
                                                        <td>$visitation</td>
                                                    </tr>
                                                                    ";
                                                                    $i++;
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