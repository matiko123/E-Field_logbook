<?php
require_once "../control/connection.php";
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
    $action =$_POST['action'];
    if($action==='register'){
    $organization=$_POST['organization'];
    $sql="insert into organization (name) values('$organization') ";
    if ($conn->query($sql) === TRUE) {  
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
}elseif($action==='upload'){
    $organization_id=$_POST['organization_id'];
    $name=$_POST['name'];
    $sql="update organization set name = '$name' where id = $organization_id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
  }

  //query selector for all organizations
$query1 = "SELECT * FROM organization ";
$result1 = mysqli_query($conn, $query1);
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

                    <div class="sidebar-brand-text mx-3"><span>COORDINATOR</span></div>
                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="assignment.php"><i class="fa fa-book"></i><span>Assignment</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="students.php"><i class="fa fa-book"></i><span>Students</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="visiting.php"><i class="fa fa-book"></i><span>Visitors</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="reporters.php"><i class="fa fa-book"></i><span>Reporters</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-book"></i><span>Organizations</span></a></li>
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
                        <h3 class="text-dark mb-0">Dashboard</h3><button class="btn btn-primary" type="button" onclick="newApplication()"><i class="fa fa-plus-square"></i>&nbsp;New&nbsp; Organization</button>
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
                                                <form method="post" action="">
                                                    <input type="hidden" name="action" value="register">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Organization's Name</strong><br></label>
                                                            <input class="form-control" type="text" id="username" placeholder="organization's name" name="organization" required>
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
                            <div class="container-fluid">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Registered Organizations</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                            <table class="table my-0" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Organization Name</th>
                                                        <th>Update</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php           $i=1;
                                                                while($row1= $result1->fetch_assoc()) {
                                                                    $name=$row1['name'];
                                                                    $org_id=$row1['id'];
                                                                    echo"
                                                                 <tr>
                                                                    <td>$i</td>
                                                                    <td>$name</td>
                                                                     <td>        
                                                                     <button class='btn btn-secondary' data-bs-toggle=\"modal\" data-bs-target=\"#edit$i\">Edit</button>
                                                                     </td>
                                                                    <td>
                                                                      <form method='post' action=''>
                                                                      <input type='hidden' name='action' value='delete'> 
                                                                      <input type='hidden' name='organization_id' value='$org_id'> 
                                                                      <button class='btn btn-danger' type='submit'>Delete</button>
                                                                      </form>
                                                                    </td>
                                                                 </tr>
                                                                 ";

                                                                 echo '
                                                                        <!-- User Login Modal Starts -->
<div class="modal fade" id="edit'.$i.'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content"   style="background-color:white!important">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post">
      <input type="hidden" name="action" value="upload">
      <input type="hidden" name="organization_id" value="'.$org_id.'">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label"> Edit Organization\'s name</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" pattern="[a-zA-Z0-9@_,.\s]+" title="Please enter alphanumeric characters or email only!"  name="name" value="'.$name.'" required>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary" >Submit</button>
      </div>
  </form>
    </div>
    </div>
  </div>
</div>
  <!--User Login Modal ends-->
                                                                 ';
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
                    <div class="text-center my-auto copyright"><span data-bs-toggle="modal" data-bs-target="#login">Copyright © ifmstudents 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

       <!-- User Login Modal Starts -->
<div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content"  style="border:solid rgb(223, 229, 231)">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="get">
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label"> Edit Organization's name</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" pattern="[a-zA-Z0-9@.\s]+" title="Please enter alphanumeric characters or email only!"  name="phone" required>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary" >Submit</button>
      </div>
  </form>
    </div>
    </div>
  </div>
</div>
  <!--User Login Modal ends-->

    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script>
        function newApplication(){
            application.style.display="block";
        }
    </script>
</body>

</html>