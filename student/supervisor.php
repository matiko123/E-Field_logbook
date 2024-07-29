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

//query selector for supervisors
function getSupervisors($conn,$sql){
    $query = "SELECT * FROM $sql ";
    $result = mysqli_query($conn, $query);
    
    return $result;
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
                    <div class="sidebar-brand-text mx-3"><span>STUDENT</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link" href="logbooks.php"><i class="fas fa-user"></i><span>Logbooks</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="supervisor.php"><i class="fa fa-user-md"></i><span>Supervisor</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="documents.php"><i class="fa fa-user-md"></i><span>Drafts</span></a></li>
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
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Visiting Supervisor Details</p>
                            
                        </div>
                        <div class="card-body">
                   
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="<?php echo $display?>">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Supervisor Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Office No</th>
                                            <th>Visitation date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                    $sql='student inner join field_selection on student.id=field_selection.student
                                     inner join organization on organization.id= field_selection.organization 
                                     inner join visiting_organization on visiting_organization.organization=organization.id 
                                     inner join visiting_supervisor on visiting_supervisor.id=visiting_organization.visitor 
                                     where field_selection.verification=1 and student.id='.$id.'';                      
                                    $result1= getSupervisors($conn,$sql);
                                                                while($row1 = $result1->fetch_assoc()) {
                                                                    $name=$row1['full_name'];
                                                                    $phone=$row1['phone'];
                                                                    $email=$row1['email'];
                                                                    $office_no=$row1['office_no'];
                                                                    $visitation=$row1['visitation'];
                                                               
                                                                    if($visitation==''){
                                                                        $visitation="<i><label class='text-danger'>No date set..</label></i>";
                                                                    }
                                                                    echo " 
                                                                      <tr>
                                            <td>$name</td>
                                            <td>$phone</td>
                                            <td>$email</td>
                                            <td>$office_no</td>
                                            <td>$visitation</td>
                                        </tr>
                                                                    ";
                                                                }   
                                                                ?>
                                        
                                    
                                    </tbody>
                                
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-------------------------------------------------->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Report Supervisor Details</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Supervisor Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Office No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $sql='report_supervisor inner join student on student.report_supervisor=report_supervisor.id where student.id='.$id.'';                      
                                    $result1= getSupervisors($conn,$sql);
                                                                while($row1 = $result1->fetch_assoc()) {                                                           
                                                                    $name=$row1['full_name'];
                                                                    $phone=$row1['phone'];
                                                                    $email=$row1['email'];
                                                                    $office=$row1['office_no'];
                                                                    echo "
                                                                    <tr>
                                                                      <td>$name</td>
                                                                      <td>$phone</td>
                                                                      <td>$email</td>
                                                                      <td>$office</td>     
                                                                    </tr>
                                                                    ";     
                                                                }
                                                                ?>
                                        
                                    
                                    </tbody>
                                   
                                </table>
                            </div>
                        </div>
                    </div>
<!------------------------------------------------------------->

                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © ifmstudents 2024</span></div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>

</html>