<?php
    // define variables and set to empty values
    $nameErr = $emailErr = "";
    $name = $email = "";

    $con = mysqli_init();
    mysqli_ssl_set($con,NULL,NULL, "ad_login_DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($con, "ad-webapp.mysql.database.azure.com", "adwebapp", "Sunit123!@#", "ad_login", 3306, MYSQLI_CLIENT_SSL);
    
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
    else {
        echo "Connected to MySQL DB on Azure..!!";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
        }
    }
    
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
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

<html>
<head>
    <title>Azure WebApp Login</title>
</head>
<body>
    <h2>Azure WebApp Login</h2>
    
    <p><span class="error">* required field</span></p>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
        Name: <input type="text" name="name" value="<?php echo $name;?>">
        <span class="error">* <?php echo $nameErr;?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">  
    </form>

</body>
</html>
