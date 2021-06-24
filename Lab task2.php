<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $dobE= $genderErr = $degreeE = $websiteErr = $bgE="";
$name = $email = $dd= $mm=$yyyy= $gender = $degree = $bg="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
      $name="";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $email="";
    }
  }
  
  	if(empty($_POST["dd"]) or empty($_POST["mm"]) or empty($_POST["yyyy"])){
		$dobE="Full Date of birth input is requied";
		$dd = test_input($_POST["dd"]);
		$mm = test_input($_POST["mm"]);
		$yyyy = test_input($_POST["yyyy"]);

	}
	else
	{
		$dd = test_input($_POST["dd"]);
		$mm = test_input($_POST["mm"]);
		$yyyy = test_input($_POST["yyyy"]);
		

		if( !filter_var($dd,FILTER_VALIDATE_INT,array('options' => array(
            'min_range' => 1, 
            'max_range' => 31
        )))|!filter_var($mm,FILTER_VALIDATE_INT,array('options' => array(
            'min_range' => 1, 
            'max_range' => 12
        )))|!filter_var($yyyy,FILTER_VALIDATE_INT,array('options' => array(
            'min_range' => 1953, 
            'max_range' => 1998
        ))))
		
			{$dobE="Must be valid numbers(dd:1-31,mm: 1-12,yyyy: 1953-1998)";}
	}
	if(!isset($_POST["gender"]))
	{
		$genderE="At least one of them must be selected";
	}


	if(!isset($_POST["degree"]))
	{
		$degreeE="Must be selected";
		
	}
	
	else if (sizeof($_POST["degree"])<2)
	{
		$degreeE="At least two must be selected";
	}
	
	
    
  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
  
	if(!isset($_POST["bg"]))
	{
		$bgE="Must be selected";
	}
	else
	{
		
		if($_POST["bg"]=="blank")
		{
			$bgE="Must be selected";
		}
		else {
    $bg = test_input($_POST["bg"]);
  }
		
	}

   
}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  

<table>
<tr style="text-align: center;">
	<th style="font-weight: normal;"><label for="dd" >dd</label></th>
	<th></th>
	<th style="font-weight: normal;"><label for="mm" >mm</label></th>
	<th></th>
	<th style="font-weight: normal;"><label for="yyyy" >yyyy</label></th>
	<th></th>
</tr>
<tr>
<td><input type="text" name="dd" style="width: 30px" value="<?php echo $dd;?>"></td>
<td>/</td>
<td><input type="text" name="mm" style="width: 30px" value="<?php echo $mm;?>"></td>
<td>/</td>
<td><input type="text" name="yyyy" style="width: 30px;" value="<?php echo $yyyy;?>"></td>
<td style="padding-left: 10px"><span class="error">* <?php echo $dobE;?></span></td>
</tr>
</table>
<hr style="border: 0.1px solid;">

<br>

 Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>


<fieldset style="width: 300px; ">
<legend><b>DEGREE</b></legend>
	<input type="checkbox" id="degree" name="degree[]" value="ssc"> SSC
	<input type="checkbox" id="degree" name="degree[]" value="hsc"> HSC
	<input type="checkbox" id="degree" name="degree[]" value="bsc"> BSc
	<input type="checkbox" id="degree" name="degree[]" value="msc"> MSc
	<br>	
	<span class="error" >* <?php echo $degreeE;?></span>			

<hr style="border: 0.1px solid;">

</fieldset>

<br>
<fieldset style="width: 300px; ">
<legend><b>BLOOD GROUP</b></legend>
	<select name="bg" id="bg">
		<option value="blank">Select</option>
		<option value="AB+">AB+</option>
		<option value="AB-">AB-</option>
		<option value="A+">A+</option>
		<option value="A-">A-</option>
		<option value="B+">B+</option>
		<option value="B-">B-</option>
		<option value="O+">O+</option>
		<option value="O-">O-</option>
	</select>	
	<br>	
	<span class="error" >* <?php echo $bgE;?></span>			

<hr style="border: 0.1px solid;">

</fieldset>
  
 
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $gender;
echo "<br>";
echo $dd;
echo "/";
echo $mm;
echo "/";
echo $yyyy;
echo "<br>";
echo $degree;
echo "<br>";
echo $bg;
echo "<br>";





?>

</body>
</html>