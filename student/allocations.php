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


//function for query selectors
function selector($conn,$sqlfinder){
    $result = mysqli_query($conn, $sqlfinder);
    return $result;
}



if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='register'){
    $organization_id=$_POST['organization_id'];
    $location=$_POST['location'];
    $email=$_POST['email'];
    $sql="insert into field_selection(student,organization,location,email) values('$id','$organization_id','$location','$email')";
    if ($conn->query($sql) === TRUE) {  
      //  echo "<script>alert('$organization_id and $visitor_id');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}elseif($action==='approve'){
    $organization_id=$_POST['organization_id'];
    $sql="update field_selection set verification=1 where student=$id and organization=$organization_id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}




//query selector for all organizations
$query1 = "SELECT * FROM organization ";
$result1= selector($conn,$query1);
//query selector for field selections made
$query2 = "SELECT location,status,organization.id,organization.name,verification FROM field_selection inner join organization on organization.id=field_selection.organization where student=$id";
$result2= selector($conn,$query2);

//query finder for allowing registry
$query = "SELECT count(id) as list from field_selection where student=$id ";
$result = selector($conn,$query);
while($row1 = $result->fetch_assoc()) {
    $list=$row1['list'];
}
if($list>2){
    $display="none";
} else{
    $display="block";
}
//query finder for allowing verification
$query4= "select * from field_selection where student= $id and verification=1";
$result4= selector($conn,$query4);
if ($result4->num_rows > 0) {
$rest="disabled";
}else{
    $rest='';
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
                <ul class="navbar-nav text-light" id="accordionSidebar">         
                    <li class="nav-item"><a class="nav-link active" href="allocations.php"><i class="fa fa-building-o"></i><span>Field Allocations</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="logbooks.php"><i class="fas fa-user"></i><span>Logbooks</span></a></li>  
                    <li class="nav-item"><a class="nav-link" href="supervisor.php"><i class="fa fa-user-md"></i><span>Supervisor</span></a></li>
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
                <div class="container-fluid" style="display:<?php echo $display ?>">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                       <button class="btn btn-primary" type="button" onclick="newApplication()"><i class="fa fa-plus-square"></i>&nbsp;New&nbsp; Application</button>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="col-md-4">
                            <section class="clean-block clean-form dark"></section>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8">
                               
                                <div class="row" style="display: none;" id="application">
                                    <div class="col">
                                        <div class="card shadow mb-3">
                                            <div class="card-body">
                                            <form  method="post" action="">
                                                <input type="hidden" name="action" value="register" >
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
                                                    <div class="row">
                                                        <div class="col">
                                                            
                                                            <div class="mb-3"><label class="form-label" for="first_name"><strong>Organization's Location</strong><br></label><input class="form-control" type="text" id="first_name" placeholder="Region-District-Street" name="location"></div>
                                                            <div class="mb-3"><label class="form-label" for="first_name"><strong>Organization's Email</strong><br></label><input class="form-control" type="email" id="first_name" placeholder="abc@organizaton.com" name="email"></div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3"></div>
                                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-upload"></i>Submit&nbsp;</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Selections Made</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                            <table class="table my-0" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Organization Name</th>
                                                        <th>Location</th>
                                                        <th>Status</th>
                                                        <th>Verify</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php    
                                                         $i=1;
                                                                while($row1 = $result2->fetch_assoc()) {
                                                                    $organization_id=$row1['id'];
                                                                    $organization_name=$row1['name'];
                                                                    $location=$row1['location'];
                                                                    $status=$row1['status'];
                                                                    $verification=$row1['verification'];                                                                    
                                                                    if($status==0 && $verification==0){
                                                                        $status="Awaiting approval";
                                                                        $class="text-danger";
                                                                        $button='<label class="text-secondary">Awaits</label>';
                                                                    
                                                                    }elseif($status==1 && $verification==0){
                                                                        $status="Approved";
                                                                        $class="text-success";
                                                                        $button='<button class="btn btn-outline-primary '.$rest.'">Verify</button>';
                                                                    }else{
                                                                        $status="Approved";
                                                                        $class="text-success";
                                                                        $button='<label class="text-success">Verified</label>';
                                                                    }
                                                                    
                                                                    echo " 
                                                    <tr>
                                                        <td>$i</td>
                                                        <td>$organization_name</td>
                                                        <td>$location</td>
                                                        <td class='$class'>$status</td>
                                                        <td>
                                                         <form  method='post' action=''>
                                                          <input type='hidden' name='action' value='approve' >
                                                          <input type='hidden' name='organization_id' value='$organization_id' >  
                                                           $button
                                                          </form>
                                                        </td>
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
                    <div class="card shadow"></div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script>
        function newApplication(){
            application.style.display="block";
        }
        function closeApplication(){
            application.style.display="none";
        }
    </script>
</body>

</html>