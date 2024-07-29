<?php
//initializing database connection.
include '../control/connection.php';
//query selector for all visiting supervisors
$query = "SELECT student.*,student.id as student_id,documents.* FROM student inner join documents on documents.student=student.id order by student.id desc";
$result = mysqli_query($conn, $query);
if($_SERVER["REQUEST_METHOD"]=="POST" ){
    $grades =$_POST['grades'];
    $student_id =$_POST['student_id'];

    $sql="update student set grading=$grades where id=$student_id";
      $conn->query($sql);
      header('Location: students.php');
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
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="details.php"><i class="fa fa-book"></i><span>Students Details</span></a></li> 
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
                                                        <th>Draft</th>
                                                        <th>Submitted on</th>
                                                        <th>Report</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php     $i=1;
                                                                while($row = $result->fetch_assoc()) {
                                                                    $id=$row['id'];
                                                                    $student_id=$row['student_id'];
                                                                    $name=$row['name'];
                                                                    $grade=$row['grading'];
                                                                    $contact=$row['contact'];
                                                                    $course=$row['course'];
                                                                    $year=$row['year'];
                                                                    $date=$row['upload_date'];
                                                                    $file=$row['file'];
                                                                    $draft=$row['draft'];
                                                                    $comments=$row['comments'];
                                                                    if($comments==''){
                                                                        $comments='<button class="btn btn-outline-primary btn-sm" type="button" onclick="window.location.href=\'attend.php?comment='.$id.'\'">Comment</button>';
                                                                        $downloads='<a href="../student/'.$file.'"><button class="btn btn-outline-primary btn-sm" type="button" >Download</button></a>';
                                                                    }else{
                                                                        $comments='<button class="btn btn-outline-success btn-sm" type="button" onclick="window.location.href=\'attend.php?comment='.$id.'\'">View</button>';
                                                                        $downloads='<a href="../student/'.$file.'"><button class="btn btn-outline-success btn-sm" type="button" >Download</button></a>';
                                                                    }if($draft==3){
                                                                        if($grade==''){
                                                                            $comments='<button class="btn btn-primary btn-sm" type="button" data-bs-toggle=\'modal\' data-bs-target=\'#grading'.$i.'\'>Assign Grades</button>';
                                                                           
                                                                        }else{
                                                                            $comments='<label class="text-dark fw-bold">Grade :&nbsp '.$grade.'%</label>';
                                                                    }
                                                                }
                                                                    echo '
                                                                    <tr>
                                                        <td>'.$i.'</td>    
                                                        <td>'.$name.'</td>
                                                        <td>'.$draft.'</td>
                                                        <td>'.$date.'</td>
                                                        <td>'.$downloads.'</td>
                                                        <td>'.$comments.'</td>
                                                    </tr>
 <!--view starts-->  
<div class="modal fade" id="grading'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" style="background-color:white!important">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Grades Assignment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Student : '.$name.'</h1><br>
           <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Enter Grading Marks from 0 to 100</label>
                <input type="number" class="form-control" id="recipient-name" name="grades" required>
                 <input type="hidden" class="form-control" id="recipient-name" name="student_id" value="'.$student_id.'">
              </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary" >Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--view ends-->
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