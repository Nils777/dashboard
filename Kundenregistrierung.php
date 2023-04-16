<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Kundenregistrierung</title>
  </head>
  <body>
    <div class="Kundenregistrierung">
      <h1>Kundenregistrierung</h1>
    </div>

    <div class="Container">
      <form method="post">
        <label for="vorname" class="kontaktformular">Vorname:</label>
        <input type="text" name="vorname" required><br>
        <label for="nachname" class="kontaktformular">Nachname:</label>
        <input type="text" name="nachname" required><br>
        
        <input type="submit" name="register" value="Registrieren" class="Button">
      </form>
    </div>
    
    <style>
      body{
        background-color: lightblue;
        line-height: 160%;
      }
      .Container{
        background-color: rgb(250, 249, 244);
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        margin-right: 10px;
        margin-left: 10px;
        font-weight: bold;
        border-color: black;
        border-width: 2px;
        border-style: solid;
      }
      .Kundenregistrierung{
        padding-left: 20px;
      }
      .Button{
        font-weight: bold;
        font-size: 15px;
      }
      .kontaktformular{
        float:left;
        width:90px;
      }
    </style>
    
    <?php 
    session_start();
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    
    if(isset($_POST['register'])) {
      $error = false;
      $vorname = $_POST['vorname'];
      $nachname = $_POST['nachname'];

        // Check if the values already exist in the database
  $statement = $pdo->prepare("SELECT COUNT(*) FROM Kunden_ID WHERE vorname=:vorname AND nachname=:nachname");
  $statement->execute(array('vorname' => $vorname, 'nachname' => $nachname));
  $result = $statement->fetchColumn();
  if($result > 0) {
    // Display an error message to the user
    echo "Die Kombination aus Vorname und Nachname ist bereits registriert.";
    $error = true;
  }

      
      
      //Keine Fehler, wir können den Nutzer registrieren
      if(!$error) {   
        $statement = $pdo->prepare("INSERT INTO Kunden_ID (vorname,nachname) VALUES (:vorname,:nachname)");
        $result = $statement->execute(array('nachname' => $nachname, 'vorname' => $vorname));
        var_dump($pdo->errorInfo());
        header('Location: ' . $_SERVER['PHP_SELF']); // reload the page
        exit(); // terminate script execution
      } 
    }
    ?>

  </body>
</html>
