<?php
// Define variables and initialize with empty values
$name = $email = $cpf = "";
$name_err = $email_err = $cpf_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    } elseif(!ctype_digit($input_cpf) && $input_cpf.length > 11){
        $cpf_err = "Digite um CPF válido (Somente números).";
    } else{
        $cpf = $input_cpf;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($cpf_err)){
        require "../backend/index.php";
        insere();
    }    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add contact record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cpf_err)) ? 'has-error' : ''; ?>">
                            <label>CPF</label>
                            <input type="text" name="cpf" class="form-control" value="<?php echo $cpf; ?>">
                            <span class="help-block"><?php echo $cpf_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>