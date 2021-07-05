<?php
/*INSERT INTO `notes` (`sno`, `title`, `description`, `stamp`) VALUES ('2', 'oh mah god', 'let\'s do some work', current_timestamp());*/
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
 
// create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
 
if (!$conn) {
 die("sorry fail to connect: ". mysqli_connect_error());
}
 /*else{echo "connection Successfull";
}*/
//echo $_SERVER['REQUEST_METHOD'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    //Update the Records
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

    $sql3= "UPDATE `notes` SET 'title' = $titleEdit, `description` = $descriptionEdit   WHERE  `notes`.`sno` = $snoEdit";
    $result3 = mysqli_query($conn,$sql3);

    if($result3 = TRUE){
      echo  "<div class='alert alert-success' role='alert'>Records Updated Successfully</div>";
    }else{
      echo "Records was not Updated Successfully!"; }
  }else{
     $title= $_POST['title'];
     $description= $_POST['description'];
 
    $sql1 = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
     $result1 = mysqli_query($conn,$sql1);
 
    if($result1 = TRUE){
    echo "<div class='alert alert-success' role='alert'>Records Added Successfully</div>";
    }else{
     echo "the record was not inserted sucessfully";
     mysqli_error($conn); }
  }
}
?>
<!doctype html>
<html lang="en">
 <head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
 
   <title>Crude  with Operations</title>
 </head>
 <body>
    <!-- Button trigger modal 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit Modal</button>-->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Modal Records</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
           <div class="form-group">
             <label for="title">Note Title</label>
               <input type="text" id="titleEdit" name="titleEdit" class="form-control">
               </div>
               <div class="form-group">
                 <label for="note description">Note Description</label>
                 <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
               </div>
                <button type="submit" name="Update" class="btn btn-primary">Update Note</button>
          </form>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
   <h2>Add A Note</h2>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
 <a class="navbar-brand" href="#">Navbar</a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
   <ul class="navbar-nav mr-auto">
     <li class="nav-item active">
       <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
     </li>
     <li class="nav-item">
       <a class="nav-link" href="#">About</a>
     </li>
      <li class="nav-item">
       <a class="nav-link" href="#">Contact Us</a>
     </li>
   </ul>
   <form class="form-inline my-2 my-lg-0">
     <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
   </form>
 </div>
</nav>
 
<div class="container my-4">
  <h2>Add A note</h2>
    <form action="index.php" method="POST">
     <div class="form-group">
       <label for="title">Note Title</label>
       <input type="text" id="title" name="title" class="form-control" required="title">
     </div>
     <div class="form-group">
       <label for="note description">Note Description</label>
       <textarea class="form-control" id="description" name="description" rows="3" required="description"></textarea>
     </div>
     <button type="submit" name="submit" class="btn btn-primary">Add Note</button>
    </form>
</div>
 
<div class="container">
 <!-- fetch data from db -->
 <!-- <?php
   $sql = "SELECT * FROM `notes`";
   $result = mysqli_query($conn,$sql);
    echo "<table><tr><th>Sno</th><th>title</th></tr>";
 
   while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["sno"]. "</td><td>" . $row["title"]. " " . $row["description"]. "</td></tr>";
     }
   echo "</table>";
 ?> -->
 
 <table class="table" id="myTable">
 <thead>
   <tr>
     <th scope="col">Sno</th>
     <th scope="col">title</th>
     <th scope="col">description</th>
     <th scope="col">Action</th>
   </tr>

 </thead>
 <tbody>
   <?php $sql = "SELECT * FROM `notes`" ;
     $result = mysqli_query($conn,$sql); 
     $sno=0;
     while ($row = $result->fetch_assoc()) {
      $sno = $sno + 1;
     echo"<tr>
     <th scope='row'>".$row['sno']."</th>
     <td>".$row['title']." </td>
     <td>".$row['description']."</td>
     <td><button class='edit btn btn-sm btn-primary' id=".$row['sno']." data-toggle='modal' data-target='#editModal' >Edit</button> <button class='delete btn btn-sm btn-primary'>delete</button></td>
   </tr>";
     } ?>
 </tbody>
   
</table>
</div>
   <!-- Optional JavaScript -->
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
   <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <script>
     $(document).ready( function () {
     $('#myTable').DataTable();
     } );
   </script>
   <script type="text/javascript">
     edits = document.getElementsByClassName('edit');
     Array.from(edits).forEach((element)=>{
      element.addEventListener("click", (e)=>{
        console.log("edit ", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        console.log(e.target.id)
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      })
     })
   </script>
 </body>
</html>