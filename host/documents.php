<?php
$id=$_GET['student'];
//initializing database connection.
include '../control/connection.php';
//session holding the coordinator logged in
$day=0;
$week=1;
$thisday="Friday";
    //checking the day to be filled
    $dayquery = "SELECT weekno,day  from days where student= $id order by id asc";
    $dayresult = mysqli_query($conn, $dayquery);
    while($row1= $dayresult->fetch_assoc()) {
        $day=$row1['day'];
        $week=$row1['weekno'];
    }

    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['action'])){
             
        $action =$_POST['action'];
        if($action==='attend'){
            $comments=mysqli_real_escape_string($conn,$_POST['comments']);
            $commented_week=$_POST['week']; 
            $sql="insert into host_supervisor_comments (student,weekno,comments) values('$id','$commented_week','$comments')";
            if ($conn->query($sql) === TRUE) {
              echo "<script>alert('student no $id on week no $week is set by comments $comments');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }if($action==='comment'){
            $thisday=date('l');
}
        }




  //query selector for week1
  $query1 = "SELECT * FROM days where student= $id and weekno=1 ";
  $result1 = mysqli_query($conn, $query1);

    //query selector for week2
    $query2 = "SELECT * FROM days where student= $id and weekno=2 ";
    $result2 = mysqli_query($conn, $query2);
    
    //query selector for week3
    $query3 = "SELECT * FROM days where student= $id and weekno=3 ";
    $result3 = mysqli_query($conn, $query3);

    //query selector for week4
    $query4 = "SELECT * FROM days where student= $id and weekno=4 ";
    $result4 = mysqli_query($conn, $query4);
    
    //query selector for week5
    $query5 = "SELECT * FROM days where student= $id and weekno=5 ";
    $result5 = mysqli_query($conn, $query5);

    //query selector for week6
    $query6 = "SELECT * FROM days where student= $id and weekno=6 ";
    $result6 = mysqli_query($conn, $query6);
    
    //query selector for week7
    $query7 = "SELECT * FROM days where student= $id and weekno=7 ";
    $result7 = mysqli_query($conn, $query7);

     //query selector for week8
     $query8 = "SELECT * FROM days where student= $id and weekno=8 ";
     $result8 = mysqli_query($conn, $query8);

          //query selector for student details
          $query = "SELECT * FROM student where id= $id ";
          $result = mysqli_query($conn, $query);
          while($row=$result->fetch_assoc()){
            $name=$row['name'];
            $logbook=$row['logbook'];
            if($logbook==0){
                $logbook='style="display:block"';
            }else{
                $logbook='style="display:none"';
            }
          }
//host supervisor commenting object
     function setComments($conn,$id,$weekno,$thisday){
            // Get the current day of the week and time
    $currentDay = date('l');
    $currentTime = date('H:i');
   $commenting_area="";
    // Define the time range
    $startTime = '08:00';
    $endTime = '16:00';
        if($currentDay == $thisday && $currentTime >= $startTime && $currentTime <= $endTime){
        $commenting_area='
        <div class="card shadow mb-3" id="newLogbook">
                                            <div class="card-body" >
                                                <form method="post">
                                                <input type="hidden" name="action" value="attend"> 
                                                <input type="hidden" name="week" value="'.$weekno.'">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="first_name"><strong>Lesson Learnt</strong><br></label>
                                                                <textarea class="form-control" type="text" id="first_name"  name="comments" placeholder="weekly comments" required></textarea></div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-primary" type="submit" ><i class="fa fa-upload"></i>Submit&nbsp;</button></div>
                                                </form>
                                            </div>
                                        </div>
        ';
        }


        $query = "SELECT * FROM host_supervisor_comments where student= $id and weekno=$weekno ";
        $result = mysqli_query($conn, $query);
        while($row=$result->fetch_assoc()){
            $comment=$row['comments'];
            if ($result->num_rows > 0) {

             
                $commenting_area='
                    <div class="card shadow mb-3" id="newLogbook">
                                            <div class="card-body" >
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3"><label class="form-label" for="first_name"><strong>Supervisor\'s Comment</strong><br></label>
                                                                <p>'.$comment.'</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                ';   
            }
        }
        
        return $commenting_area;
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
    <link rel="stylesheet" href="../student/assets/style.css">
    <style>
        weekdiv{
            display:none;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-text mx-3"><span>Host Supervisor</span></div>
                </a>
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="students.php"><i class="fa fa-book"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link " href="visit.php"><i class="fa fa-book"></i><span>Supervisor Visitation</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <button class="btn btn-outline-primary" onclick="location.href='students.php'">
<svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-backspace">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5Z"></path>
        <path d="M12 10l4 4m0 -4l-4 4"></path>
    </svg>
                    </button>
                    <form method="post">
                            <input type="hidden" name="action" value="comment"> 
                        <button class="btn btn-outline-danger" type="submit"> Allow Host Comment </button>
                      </form>
                </div>
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
                                      
                                        <?php           $i=1;
                                                                while($row1= $result1->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'1',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </weekdiv>
                        <!---------------------------------------------------->
               <weekdiv id="week2" >
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
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php           $i=1;
                                                                while($row2= $result2->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'2',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result3->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'3',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result4->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'4',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result5->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'5',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result6->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'6',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result7->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'7',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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
                                                                while($row1= $result8->fetch_assoc()) {
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
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col">
                                    <?php 
                                    $commenting_area=setComments($conn,$id,'8',$thisday);
                                    echo $commenting_area 
                                    ?>
                                    </div>
                                </div>
                            </div>
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