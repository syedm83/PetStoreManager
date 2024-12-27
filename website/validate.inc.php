<?php
require_once('database.php');
$emailAddress = htmlspecialchars($_POST['emailAddress']);
$password = $_POST['password'];
if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
   $query = "SELECT firstName, lastName FROM admins " .
       "WHERE emailAddress = ? AND password = SHA2(?,256)";
   $query = "SELECT pronouns, firstName, lastName FROM PetSuppliesManagers " .
         "WHERE emailAddress = ? AND password = SHA2(?,256)";
   $db = getDB();
   $stmt = $db->prepare($query);
   $stmt->bind_param("ss", $emailAddress, $password);
   $stmt->execute();
   $stmt->bind_result($pronouns, $firstName, $lastName);
   $fetched = $stmt->fetch();
   $name = "$firstName $lastName ($pronouns)";
   if ($fetched && isset($name)) {
      echo "<h2>Welcome to the Pet Store Inventory website!, $name ($pronouns)</h2>\n";
      $_SESSION['login'] = $name;
      header("Location: index.php");
   } else {
      echo "<h2>Sorry, login incorrect. Please try again using your Pet Store credentials.</h2>\n";
      echo "<a href=\"index.php\">Please try again</a>\n";
   }
} else {
   echo "<h2>Please enter a valid email address</h2>\n";
   echo "<a href=\"index.php\">Please try again</a>\n";
}
?>
