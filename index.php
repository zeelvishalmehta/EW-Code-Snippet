<?php
	// Disable PHP notices
	error_reporting(E_ALL & ~E_NOTICE);

	// Include database helper functions
	include('./database.php');

	// Initialize database
	$db = new Database('audiokinetic', 'localhost', 'audiokinetic', 'ui!19Bp2'); // (database_name, host, user, password)
	if($_POST['submit']=="Add User")
	{
	
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$age = $_POST['age'];
		
		if(($fname != '') && (isset($fname)) && (!empty(trim($fname))) && ($lname != '') && (isset($lname)) && (!empty(trim($lname))) && ($age>0))
		{
			$result = $db->query("INSERT INTO users ( first_name, last_name, age ) VALUES (?,?,?)", array($fname, $lname, $age));
		header("location:index.php");
		}
		else
		{
			header('location:index.php?msg=error');	
		}
	}


	
?>
<!DOCTYPE HTML>
<html>
	<title>Users</title>
<head>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<link rel='stylesheet' type='text/css' href='style.css' />
</head>
<body>
	<form style="border:1px solid #ccc" method="post" enctype="multipart/form-data">
	
	<h2>Add New User</h2><br> 
		
		
    <div class="login">    
     <label><b>First Name:     
        </b>    
        </label>    
        <input type="text" name="fname"  placeholder=" first name" id="Uname"  required pattern="[A-Za-z]*">    
        <br><br>    
        <label><b>Last Name:    
        </b>    
        </label>    
        <input type="text" name="lname"  placeholder=" last name" id="Uname"  required pattern="[A-Za-z]*">    
        <br><br>
		  
		<label><b>Age:     
        </b>    
        </label>    
        <input type="number" name="age"  placeholder=" age" id="age"  required>    
        <br><br>
		
		<input type="submit" name="submit" value="Add User">       
        <br>  
		<?
		if($_GET['msg']!='')
		{ ?>
		<h4 style="color:red;font-size:14px;">NOTE: First Name, Last Name and age data should be valid otherwise you wouldn't be able to submit the information.</h4>
		<? }
		?><br>
         
</div>    
</form>	
	
	<table border=1 align="center" width="70%" style="margin-top:30px;">
		<tr align="center" style="font-weight:bold">
			<td>Id</td>
			<td><a href="index.php?forder=<?php echo isset($_GET['forder'])?!$_GET['forder']:1; ?>&par=fname">First Name</a></td>
			<td>Last Name</td>
			<td>
				<a href="index.php?order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>&par=age">Age</a>
			</td>
		</tr>	
		<?
		$isAge = isset($_GET['order'])? (bool) $_GET['order']: 1;
		$isfname = isset($_GET['forder'])? (bool) $_GET['forder']: 1;
		//return all users
		if($isAge && $_GET['par']=='age')
		{
		$rows = $db->fetch_rows("SELECT * FROM users order by age asc", array());
		}
		else if((!$isAge) && $_GET['par']=='age')
		{
		$rows = $db->fetch_rows("SELECT * FROM users order by age desc", array());
		}
		elseif($isfname && $_GET['par']=='fname')
		{
		$rows = $db->fetch_rows("SELECT * FROM users order by first_name asc", array());
		}
		elseif((!$isfname) && $_GET['par']=='fname')
		{
		$rows = $db->fetch_rows("SELECT * FROM users order by first_name desc", array());
		}
		else
		{
		$rows = $db->fetch_rows("SELECT * FROM users", array());
		}
		if ( $rows !== false )
		{
			foreach($rows as $row)
			{
				echo "<tr align=center>";
				echo "<td>".$row->id."</td>";
				echo "<td>".$row->first_name."</td>";
				echo "<td>".$row->last_name."</td>";
				echo "<td>".$row->age."</td>";
				echo "</tr>";
				
			}
		}

		
		
		?>
		
	</table>	
	
</body>
</html>
