<?php
require "../backend/index.php";

// Define variables and initialize with empty values
$name = $email = $cpf = "";
$name_err = $email_err = $cpf_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["nome"]);
    if(empty($input_name)){
        $name_err = "Digite o nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Digite um nome válido.";
    } else{
        $name = $input_name;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Digite um e-mail válido.";     
    } else{
        $email = $input_email;
    }
    
    // Validate cpf
    $input_cpf = trim($_POST["cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Digite o CPF (Somente números).";     
    } elseif(!ctype_digit($input_cpf)){
        $cpf_err = "Digite um CPF válido (Somente números).";
    } else{
        $cpf = $input_cpf;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($cpf_err)){
        // Prepare an update statement
        atualiza();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <?php selecionaPorId(); ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>