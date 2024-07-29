<?php

//initializing database connection.
include '../control/connection.php';
//session holding the coordinator logged in
session_start();
$marks="---";
     $grading="---";
     $remark="---";
     $color="text-dark";
if(!isset($_SESSION['id'])){
    header('Location : index.php');
}else{
    $id=$_SESSION['id'];
}

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
//query selector for drafts
$queryn = "SELECT * FROM documents where student=$id order by id desc";
$resultn = $conn->query($queryn);
if($resultn->num_rows > 0){
    $row=$resultn->fetch_assoc();
    $draft=$row['draft'];

}else{
    $draft=0;
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["report"]["name"]);
move_uploaded_file($_FILES["report"]["tmp_name"], $target_file);
    $action =$_POST['action'];
    if($action==='upload'){
    $sql="insert into documents (student,file,draft) values('$id','$target_file',$draft+1)";
    if ($conn->query($sql) === TRUE) {  

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
}

//query selector for drafts
$query1 = "SELECT * FROM documents where student=$id";
$result1 = mysqli_query($conn, $query1);

//query selector for drafts
$query2 = "SELECT count(id) as max_limit FROM documents where student=$id";
$result2 = mysqli_query($conn, $query2);
while($row1 = $result2->fetch_assoc()) {
    $limit=$row1['max_limit'];
    if($limit==3){
        $uploads="";
    }else{
        $uploads='
          <div class="card shadow mb-3" id="newLogbook">
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 fw-bold">Upload Document</p>
                                            </div>
                                            <div class="card-body">
                                    
                                                    <div class="row">
                                                        
                                                        <div class="col">
                                                       
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"></div>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="action" value="upload" >
                                                            <input type="file" id="report" style="display: none;" onchange="fileName()" name="report" required>
                                                            <div class="mb-3 text-center" id="drop-zone"><label class="form-label" for="first_name" style="cursor: pointer;" onclick="reportClick()" id="filename">&nbsp;Click here to Upload a File&nbsp;<br></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-primary btn-sm" type="submit" onclick=\'newLogbook.style.display="none"\'><i class="fa fa-upload"></i>Submit&nbsp;</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
        ';
    }
}

//query selector for student details
$queryn = "SELECT * from student where id=$id";
$resultn = mysqli_query($conn, $queryn);
while($row1 = $resultn->fetch_assoc()) {
    $name=$row1['name'];
    $grading=$row1['grading'];
    if($grading==''){
     $marks="---";
     $grading="---";
     $remark="---";
     $color="text-dark";
    }elseif($grading>69){
        $marks=$grading;
        $grading="A";
        $remark="Excellent";
        $color="text-success";
    }elseif($grading>59 && $grading<70){
        $marks=$grading;
        $grading="B+";
        $remark="Very good";
        $color="text-success";
    }elseif($grading>49 &&$grading<60){
        $marks=$grading;
        $grading="B";
        $remark="Good";
        $color="text-success";
    }elseif($grading>39 && $grading<50){
        $marks=$grading;
        $grading="C";
        $remark="Average";
        $color="text-success";
    }elseif($grading>29 &&$grading<40){
        $marks=$grading;
        $grading="D";
        $remark="Poor";
        $color="text-success";
    }else{
        $marks=$grading;
        $grading="F";
        $remark="Failure";
        $color="text-danger";
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
                 
                    <div class="sidebar-brand-text mx-3"><span>STUDENT</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="logbooks.php"><i class="fas fa-user"></i><span>Logbooks</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="supervisor.php"><i class="fa fa-user-md"></i><span>Supervisor</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-user-md"></i><span>Drafts</span></a></li>
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                      <?php echo $uploads ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Uploaded Drafts</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Draft</th>
                                            <th>Commited date</th>
                                            <th>Download Document</th>
                                            <th>View Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php    
                                                               $i=1;
                                                                while($row1 = $result1->fetch_assoc()) {
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['upload_date'];
                                                                    $file=$row1['file'];
                                                                    if($comments==''){
                                                                       $label="<label class='text-dark' type='button'>No comment...</label>" ;
                                                                    }else{
                                                                       $label="<button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>view</button>"; 
                                                                    }
                                                                    echo "
                                        <tr>
                                            <td>$i</td>
                                            <td>$date</td>
                                            <td><button class='btn btn-outline-success' onclick=\"window.location.href='$file'\">Download</button></td>
                                            <td><i>$label</i><br></td>
                                            <td></td>
                                        </tr>";
                                              echo '
<!--view starts-->  
<div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" style="background-color:white!important">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Superviso\'s Comment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">'.$comments.'</label>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<!--view ends-->
                                                                    ';
                                                                    $i++;
                                                                }         
                                      ?>
                                       
                                </table>
                            </div>
                        </div>

                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Grading</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Marks</th>
                                            <th>Grade</th>
                                            <th>Remark</th>
                                        </tr>
                              <?php echo "
                                        <tr>
                                            <td>$marks</td>
                                            <td>$grading</td>
                                            <td class=\"$color\">$remark</td>
                                        </tr>
                                       ";
                                       ?>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                       </div>


                                                            </div>     
                                                            </div> 
                                                            </div>  
                     

                                                            
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright" data-bs-toggle="modal" data-bs-target="#login"><span>Copyright © ifmstudents 2024</span></div>

                </div>
            </footer>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script>

    </script>
      
    <script>
    function reportClick(){
       report.click();     
    }
    function fileName(){
        filename.innerText=report.files[0].name;
       }
   </script>
</body>

</html>