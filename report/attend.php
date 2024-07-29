<?php
include '../control/connection.php';
$commentid=$_GET['comment'];
$comments="No Records available";
//update comments on students report
if($_SERVER["REQUEST_METHOD"]=="POST" ){
    $comments=mysqli_real_escape_string($conn,$_POST['comments']);
            $sql="update documents set comments='$comments' where id=$commentid";
            if ($conn->query($sql) === TRUE) {
              echo "<script>alert('document $commentid set comments $comments');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
//initializing database connection.
include '../control/connection.php';
//query selector for all visiting supervisors
$query = "SELECT student.*,documents.* FROM student inner join documents on documents.student=student.id where documents.id=$commentid order by student.id desc";
$result = mysqli_query($conn, $query);
while($row = $result->fetch_assoc()) {
    $name=$row['name'];
    $comments=$row['comments'];
    if($comments==''){
        $comments='
         <form method="post">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>Student\'s Name : '.$name.'</strong><br></label>
                                                            <textarea class="form-control" type="text" id="username"  name="comments" placeholder="Please enter your comments based on student\'s answers from your assessment" style="height: 3cm;" value="comments"></textarea></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3" ><button class="btn btn-outline-primary " type="submit"><i class="fa fa-upload" ></i>Submit&nbsp;</button></div>
                                            </form>
        ';
    }else{
        $comments='
        <form action="students.php">
                                               <div class="row">
                                                   <div class="col">
                                                       <div class="mb-3"><label class="form-label" for="username"><strong>Student\'s Name : '.$name.'</strong><br></label>
                                                           <p class="form-control" type="text" id="username"  name="username"  style="height: 3cm;">'.$comments.'</p></div>
                                                   </div>
                                               </div>
                                           </form>
       ';
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
                <div class="sidebar-brand-text mx-3"><span>Report Supervisor</span></div>
                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="students.php"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="details.php"><i class="fa fa-book"></i><span>Students Details</span></a></li>            
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <button class="btn btn-outline-primary" onclick="window.location.href='students.php'">
<svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-backspace">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5Z"></path>
        <path d="M12 10l4 4m0 -4l-4 4"></path>
    </svg>
                    </button></div>
                    
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Comments on Student's Report</h3>
                    </div>
                </div>
                <div class="container-fluid"  id="signIn">
                    <div class="row mb-3">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-body">
                                           <?php echo $comments ?>
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