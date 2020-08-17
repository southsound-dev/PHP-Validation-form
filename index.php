<?php
$name = "";
$character = "";
$email = "";
$birth_year = 1969;
$validation_error = "";
$existing_users = ["admin", "guest"];
$options = ["options" => ["min_range" => 1920, "max_range" => date("Y")]];
$regex_lowcas = "/^[A-Z]/";
$regex_email = "/\.com$/" ;
function leap($year) {
    return date('L', strtotime("$year-01-01")) ? TRUE : FALSE;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $raw_name = trim(htmlspecialchars($_POST["name"]));
  if (in_Array($raw_name,$existing_users)){
    $validation_error .= "This name is taken. <br>";
  } else {
      $name = $raw_name;
    }
    if (preg_match($regex_lowcas,$name)) {
        $validation_error .= "Names should start in lowcase. <br>";
    }
  $raw_character = $_POST["character"];
  
  if (in_array($raw_character,["wizard", "mage", "orc"])) {
    
    $character = $raw_character;
} else {
    $validation_error .= "You must pick a wizard, mage, or orc. <br>";
  }
  $raw_email = $_POST["email"];
  if (filter_var($raw_email,FILTER_VALIDATE_EMAIL)) {
    $email = $raw_email;
    if (!preg_match($regex_email,$email)) {
        $validation_error .= "Email should be a .com . <br>";
    }
  } else {
    $validation_error .= "Invalid email. <br>";
  }
  $raw_birth_year = $_POST["birth_year"];
  if (filter_var($raw_birth_year,FILTER_VALIDATE_INT,$options)){
$birth_year = $raw_birth_year;
if ($raw_character === "mage") {
    if (!leap($birth_year)){
    $validation_error .= "Mages have to be born on leap years. <br>";
  }}
} else {
  $validation_error .= "That can't be your birth year. <br>";
}

}


?>
<h1>Create your profile</h1>
<form method="post" action="">
<p>
Select a name: <input type="text" name="name" value="<?php echo $name;?>" >
</p>
<p>
Select a character:
  <input type="radio" name="character" value="wizard" <?php echo ($character=='wizard')?'checked':'' ?>> Wizard
  <input type="radio" name="character" value="mage" <?php echo ($character=='mage')?'checked':'' ?>> Mage
  <input type="radio" name="character" value="orc" <?php echo ($character=='orc')?'checked':'' ?>> Orc
</p>
<p>
Enter an email:
<input type="text" name="email" value="<?php echo $email;?>" >
</p>
<p>
Enter your birth year:
<input type="text" name="birth_year" value="<?php echo $birth_year;?>">
</p>
<p>
  <span style="color:red;"><?= $validation_error;?></span>
</p>
<input type="submit" value="Submit">
</form>
  
<h2>Preview:</h2>
<p>
  Name: <?=$name;?>
</p>
<p>
  Character Type: <?=$character;?>
</p>
<p>
  Email: <?=$email;?>
</p>
<p>
  Age: <?=date("Y")-$birth_year;?>
</p>