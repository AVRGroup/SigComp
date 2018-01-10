<?php

session_start();

$target_dir = "uploads/" . $_SESSION['login'];
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_dir = $target_dir ."/" . $_POST["tipo"];

if (!file_exists($target_dir)) {
	mkdir($target_dir, 0777, true);
}

$target_dir = $target_dir ."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); 
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image

/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}*/


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "pdf" ) {
    echo "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
    $uploadOk = 0;
}

// Check if file already exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
        echo "<script>alert('Erro ao Enviar Certificado!');
				window.location='pagAluno.php';</script>";
				exit;
// if everything is ok, try to upload file
} else {
	$tipo = $_POST["tipo"];
	$matricula = $_SESSION['login'];
	require_once 'conexao.php';
	
	$result = $conn->query("SELECT * FROM aluno WHERE matricula = '$matricula'");
            if ($result)
            {
            if ($row = $result->fetch(PDO::FETCH_OBJ))
            {
                        $qnt = $row-> $tipo;
                    }
            }
    $conn->query("UPDATE aluno set $tipo = $tipo + 1 WHERE matricula = '$matricula'");        
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $tipo. $qnt ."." . $imageFileType)) {
        
		echo "<script>alert('Certificado Enviado!');
				window.location='pagAluno.php';</script>";
				exit;
    } else {
        echo "<script>alert('Erro ao Enviar Certificado!');
				window.location='pagAluno.php';</script>";
				exit;
    }
}
?>


