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
$day=0;
$week=1;
    //checking the day to be filled
    $dayquery = "SELECT weekno,day  from days where student= $id order by id asc";
    $dayresult = mysqli_query($conn, $dayquery);
    while($row1= $dayresult->fetch_assoc()) {
        $day=$row1['day'];
        $week=$row1['weekno'];
    }

if($_SERVER["REQUEST_METHOD"]=="POST" ){
    $title=$_POST['title'];
    $comments=$_POST['comments'];
        if($day<5){
            $day+=1;
            $sql="insert into days (day,title,comments,student,weekno) values('$day','$title','$comments','$id','$week')";
            if ($conn->query($sql) === TRUE) {
                //query for updating filling form status 
                $update="update student set logbook=2 where id=$id ";
                if ($conn->query($update) === TRUE) { 
                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                } 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }if($day==5){ 
            $sql="insert into days (day,title,comments,student,weekno) values(1,'$title','$comments','$id',$week+1)";
            if ($conn->query($sql) === TRUE) {  
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }



  //query selector for all days in week
     function getdays($conn,$id,$weekno){
        $query = "SELECT * FROM days where student= $id and weekno=$weekno ";
        $result = mysqli_query($conn, $query);
        return $result;
     }

  //query selector for host supervisor comments
  function getcomments($conn,$id,$weekno){
    $hostComments="<br><label class=\"text-danger\"><i>No Comments available</i></label>";
    $query = "SELECT * FROM host_supervisor_comments where student= $id and weekno=$weekno";
    $result = mysqli_query($conn, $query);
     while($row=$result->fetch_assoc()){
        if ($result->num_rows > 0) {
            $hostComments="<br>&nbsp;".$row['comments'];   
        }
    }
       
    return $hostComments;
 }     
           $warning="

           <label class=\"text-danger\"><i>You haven't signed in today!</i></label>
           
           ";
          //query selector for student details
          $query = "SELECT * FROM student where id= $id ";
          $result = mysqli_query($conn, $query);
          while($row=$result->fetch_assoc()){
            $name=$row['name'];
            $logbook=$row['logbook'];
            if($logbook==0){
                $logbook='style="display:block"';
                $warning="";
            }elseif($logbook==2){
                $logbook='style="display:none"';
                $warning=" <label class=\"text-success\" style=\"color:green!important\"><i>Today's logbook signed!</i></label>";
            }else{
              $logbook='style="display:none"';
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
    <link rel="stylesheet" href="assets/style.css">
</head>

<body id="page-top" class="sidebar-toggled">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 toggled">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                                
                    <div class="sidebar-brand-text mx-3"><span><?php echo $name?></span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href=""><i class="fas fa-user"></i><span>Logbooks</span></a></li>
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
                <div class="container-fluid">
                    <div class="card shadow">

                    <div class="dropdown no-arrow">
            <button class="btn btn-outline-primary   " aria-expanded="false" data-bs-toggle="dropdown" type="button" >
            Select week &nbsp; <i class="fa fa-chevron-down"></i></button>
            <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in ">
            <?php
            for($i=1;$i<9;$i++){
            echo " 
               <a class=\"dropdown-item\" onclick=\"weeks('week$i')\" style=\"cursor:pointer\">&nbsp;Week $i</a>
               ";
            }
            ?>


            </div>
        </div>
                        <div class="row mb-3">
                          <div class="container">
                         <?php echo $warning ?>
          </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow mb-3" id="newLogbook" <?php echo $logbook ?>>
                                            <div class="card-header py-3">
                                                <p class="text-primary m-0 fw-bold">Today's Logbook </p>
                                            </div>
                                            <div class="card-body">
                                                <form method="post">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="username"><strong>Title</strong><br></label>
                                                            <input class="form-control" type="text" id="username"  name="title" required></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="first_name"><strong>Lesson Learnt</strong><br></label>
                                                                <textarea class="form-control" type="text" id="first_name"  name="comments" required></textarea></div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-primary" type="submit" ><i class="fa fa-upload"></i>Submit&nbsp;</button></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">My Logbook</p>
                        </div>
                       <!---------------------------------------------------->
                   <weekdiv id="week1" style="display:block">
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 1</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php          
                                         $i=1;
                                         $days= getdays($conn,$id,'1');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                  
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td><span class=\"d-inline-block text-truncate\" style=\"max-width: 150px;\">$comments</span></td>
                                                                         <td>$date</td>
                                                                         <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                            <?php
                               $host_comments= getcomments($conn,$id,'1');
                               echo $host_comments; 
                            ?>
                            </p>
                        </div>
                </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week2">
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 2</p>
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>Verify</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php           $i=1;
                                    $days= getdays($conn,$id,'2');
                                                                while($row2= $days->fetch_assoc()) {
                                                                    $title=$row2['title'];
                                                                    $comments=$row2['comments'];
                                                                    $date=$row2['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                  <?php
                               $host_comments= getcomments($conn,$id,'2');
                               echo $host_comments ;
                            ?>
                            </p>
                        </div>

                        </weekdiv>
                        <!---------------------------------------------------->
                     <weekdiv id="week3">
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 3</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'3');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                 <?php
                               $host_comments= getcomments($conn,$id,'3');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week4">

                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 4</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'4');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                <?php
                               $host_comments= getcomments($conn,$id,'4');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week5">

                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 5</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'5');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                <?php
                               $host_comments= getcomments($conn,$id,'5');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week6">

                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 6</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'6');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                 <?php
                               $host_comments= getcomments($conn,$id,'6');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week7">
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 7</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'7');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                 <?php
                               $host_comments= getcomments($conn,$id,'7');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week8">
                        <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Week 8</p>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Lesson Learnt</th>
                                            <th>Commited date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php           $i=1;
                                         $days= getdays($conn,$id,'8');
                                                                while($row1= $days->fetch_assoc()) {
                                                                    $title=$row1['title'];
                                                                    $comments=$row1['comments'];
                                                                    $date=$row1['time'];
                                                                    echo"
                                                                  <tr>
                                                                         <td>$i</td>
                                                                         <td>$title</td>
                                                                         <td>$comments</td>
                                                                         <td>$date</td>
                                                                           <td><button class='btn btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#view$i'>View</button></td>
                                                                  </tr>
                                                                         ";
                                                                         echo ' <!--view starts-->  
                                                                         <div class="modal fade" id="view'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                                           <div class="modal-dialog" style="background-color:white!important">
                                                                             <div class="modal-content">
                                                                               <div class="modal-header">
                                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Title : '.$title.'</h1>
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
                                                                         <!--view ends-->';
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
                          <div class="card-body">
                            <p class="text-primary m-0 fw-bold">Host Supervisor's Assessment</p>
                            <p class="text-dark m-0 shadow">
                                 <?php
                               $host_comments= getcomments($conn,$id,'8');
                               echo $host_comments 
                            ?>
                            </p>
                        </div>
                        </weekdiv>
                        <!---------------------------------------------------->


                    </div>
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
    <script>
        function weeks(weekno){
            document.querySelectorAll('weekdiv').forEach(el =>el.style.display="none");
            showWeek=document.getElementById(weekno);
            showWeek.style.display="block";
        }
    </script>
</body>

</html>