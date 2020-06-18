<?php
    
    include_once 'conexao.php';

    function seleciona() {

        try {
            $database = new Conexao();
            $db = $database->abreConexao();

            $res = $db->query("SELECT id, nome, email, cpf FROM tbl_pessoas ORDER by nome");
            
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Nome</th>";
                    echo "<th>E-mail</th>";
                    echo "<th>CPF</th>";
                    echo "<th>Ação</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                    echo "<td>" . $linha['id'] . "</td>";
                    echo "<td>" . $linha['nome'] . "</td>";
                    echo "<td>" . $linha['email'] . "</td>";
                    echo "<td>" . $linha['cpf'] . "</td>";
                    echo "<td>";
                        echo "<a href='update.php?id=". $linha['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        echo "<a href='delete.php?id=". $linha['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
            echo "</table>";

            $database->fechaConexao();

        } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
        }
    }

    function insere() {

        try {
            $database = new Conexao();
            $db = $database->abreConexao();

            // inserting data into create table using prepare statement to prevent from sql injections
            $stm = $db->prepare("INSERT INTO tbl_pessoas (nome, email, cpf) VALUES ( :nome, :email, :cpf)");

            // inserting a record
            $stm->execute(array(':nome' => $_POST['nome'], ':email' => $_POST['email'], ':cpf' => $_POST['cpf']));

            //echo "New record created successfully";
            header("location: index.php");
            exit();

            $database->fechaConexao();

        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }

    function atualiza() {

        try {
                $database = new Conexao();
                $db = $database->abreConexao();
                 // Prepare an update statement
                $sql = "UPDATE tbl_pessoas SET nome=:nome, email=:email, cpf=:cpf WHERE id=:id";
                if($stmt = $db->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":nome", $param_nome);
                    $stmt->bindParam(":email", $param_email);
                    $stmt->bindParam(":cpf", $param_cpf);
                    $stmt->bindParam(":id", $param_id);

                    // Set parameters
                    $param_nome = $_POST['nome'];
                    $param_email = $_POST['email'];
                    $param_cpf = $_POST['cpf'];
                    $param_id = $_GET['id']; 

                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Records updated successfully. Redirect to landing page
                        header("location: index.php");
                        exit();
                    } else{
                        echo "Something went wrong. Please try again later.";
                    }
                }
        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }
    
    function selecionaPorId() {

        // Processing form data when form is submitted
        if(isset($_GET["id"]) && !empty($_GET["id"])) {
            // Get hidden input value
            $id = $_GET["id"];
            try {
                $database = new Conexao();
                $db = $database->abreConexao();

                $res = $db->query("SELECT id, nome, email, cpf FROM tbl_pessoas WHERE id = $id ORDER by nome");
                
                while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
                    
                    $id = $linha['id'];
                    $nome = $linha['nome'];
                    $email = $linha['email'];
                    $cpf = $linha['cpf'];

                    echo "<div class='form-group'>";
                    echo "<label>Nome</label>";
                    echo "<input type='text' name='nome' class='form-control' value='$nome'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>E-mail</label>";
                    echo "<input type='text' name='email' class='form-control' value='$email'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label>CPF</label>";
                    echo "<input type='text' name='cpf' class='form-control' value='$cpf'>";
                    echo "</div>";
                }

                $database->fechaConexao();

            } catch (PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
            }
        }
    }

    function delete() {
 
        // Process delete operation after confirmation
        if(isset($_POST["id"]) && !empty($_POST["id"])){

            $id = $_POST['id'];

            try {
                $database = new Conexao();
                $db = $database->abreConexao();

                $stmt = $db->prepare('DELETE FROM tbl_pessoas WHERE id = :id');
                $stmt->bindParam(':id', $id); 
                $stmt->execute();
                    
                echo $stmt->rowCount(); 

                $database->fechaConexao();

                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Records updated successfully. Redirect to landing page
                    header("location: index.php");
                    exit();
                } else{
                    echo "Something went wrong. Please try again later.";
                }

            } catch(PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }

?>