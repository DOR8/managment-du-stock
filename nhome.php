<?php
   session_start();
   $userName=$_SESSION['userName'];
   if(!isset($_SESSION['userName']))
   {
     header("Location:login.php");
   }
   ?>
<html>
   <head>
      <style>
         * {
         box-sizing: border-box;
         }
         body {
         font-family: Arial, Helvetica, sans-serif;
         }
         /* Style the header */
         .header {
         grid-area: header;
         background-color: #E98C53;
         padding: 30px;
         text-align: center;
         font-size: 35px;
         }
         /* The grid container */
         .grid-container {
         display: grid;
         grid-template-areas: 
         'header header header header header header' 
         'left middle middle middle middle middle' 
         'footer footer footer footer footer footer';
         /* grid-column-gap: 10px; - if you want gap between the columns */
         } 
         .left,
         .middle,
         .right {
         padding: 10px;
         min-height: 400px; /* Should be removed. Only for demonstration */
         overflow: scroll;
         }
         /* Style the left column */
         .left {
         grid-area: left;
         }
         /* Style the middle column */
         .middle {
         grid-area: middle;
         }
         /* Style the right column */
         .right {
         grid-area: right;
         }
         /* Style the footer */
         .footer {
         grid-area: footer;
         background-color: #85C1E9;
         padding: 10px;
         text-align: center;
         }
         table {
         border-collapse: collapse;
         width: 100%;
         }
         th, td {
         text-align: left;
         padding: 8px;
         }
         th {
         background-color: #4CAF50;
         color: white;
         }
      </style>
   </head>
   <body>
      <div class="grid-container">
         <div class="header">
            <h2 style="color: #2E4053"; align="left">XCompany  </h2>
         </div>
         <div class="left" style="background-color:#aaa;">
            <ul>
               <li><a href="nhome.php">Dashboard</a></li>
               <li><a href="view.php?userName=<?php echo $userName; ?>">View Profile</a></li>
               <li><a href="edit.php">Edit Profile</a></li>
               <li><a href="changepic.php">Change Profile Picture</a></li>
               <li><a href="changepass.php">Change Password</a></li>
               <li><a href="logout.php">Logout</a></li>
            </ul>
         </div>
         <div class="middle" style="background-color:#bbb;">
            <?php
               $name=$_SESSION['name'];
               echo "<h5>Welcome $name</h5>";
               ?>
            <fieldset align="center">
               <legend>Add Product</legend>
               <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                  <div> 
                     <p>Nom</p>
                     <input type="text" name="pname">
                  </div>
                    
                  <p>
                  <select name="ptype">
                  <option value="">Select Course</option>
                  <option value="web Designing">Web Designing</option>
                  <option value="web Development">Web Development</option>
                  <option value="app Development">app development</option>
                  <option value="game development">Game Development</option>
                  <option value="graphic Designing">Graphic Desiging</option>
                  <option value="digital marketing">Digital Marketing</option>
                  </select>
                  </p>
                  <div>
                     <p>Quantity</p>
                     <input type="number" name="pquantity">
                  </div>
                  <div>
                     <p>Numero de serie</p>
                     <input type="number" name="Nserie">
                  </div>
                  <div>
                     <p>Fournisseur</p>
                     <input type="text" name="fourni">
                  </div>
                     <input type="submit" name="addProduct" value="ADD"/>
               </form>
            </fieldset>
            <?php
               $con=mysqli_connect("localhost","root","","pdm3");
               if(!$con)
               {
                 die("Connection Error: ".mysqli_connect_error()."<br/>");
               }
             
               $sql="SELECT * FROM products";
               $result=mysqli_query($con,$sql);
               if(mysqli_num_rows($result)>0)
                {
                 ?>
                 <table border='1' cellpadding='8'>
                   <tr>
                     <th>Product ID</th>
                     <th>Nom de Produit</th>
                     <th>Type</th>
                     <th>Quantité de Produit </th>
                     <th>Numero de Serie</th>
                     <th>Fournisseur</th>
                     <th>Actions</th>
                   </tr>
                 <?php
                 while($row=mysqli_fetch_array($result))
                 {
                   echo "<tr>";
                   echo "<td>".$row['pid']."</td>";
                   echo "<td>".$row['pname']."</td>";
                   echo "<td>".$row['ptype']."</td>";
                   echo "<td>".$row['pquantity']."</td>";
                   echo "<td>".$row['Nserie']."</td>";
                   echo "<td>".$row['fourni']."</td>";
                   echo '<td><a href="post.php?pid=' .$row['pid'].'&pname='.$row['pname'].'&ptype='.$row['ptype'].'&pquantity='.$row['pquantity'].'&Nserie='.$row['Nserie'].'&fourni='.$row['fourni'].'">Edit</a> || <a href="delete.php?pid=' .$row['pid'].'">Delete</a></td>';
                   echo "</tr>";
             
                 
                 }
                 echo "</table>";
                }
                else
                {
                 echo "No data found.<br/>";
                }
             mysqli_close($con);   
             ?>
             
                 </div>  
               
               <div class="footer">
                 <p>Copyright © 2020</p>
               </div>
             </div>
             </body>
             </html>
             
             <?php
             if(isset($_POST['addProduct']))
             {
               $con=mysqli_connect("localhost","root","","pdm3");
               if(!$con)
               {
                 die("Connection Error: ".mysqli_connect_error()."<br/>");
               }
               //Row Insert
               $pname=$_POST['pname'];
               $ptype=$_POST['ptype'];
               $pquantity=$_POST['pquantity'];
               $Nserie=$_POST['Nserie'];
               $fourni=$_POST['fourni'];
               $sql="INSERT INTO products(pid,pname,ptype,pquantity,Nserie,fourni) VALUES('$pname','$ptype','$pquantity','$Nserie','$fourni')";
               if(mysqli_query($con,$sql))
               {
                 header("Location:nhome.php");
               }
               else
               {
                 echo "Error in inserting: ".mysqli_error($con);
               }
             mysqli_close($con);   
             }
             ?>
             