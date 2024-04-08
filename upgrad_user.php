<?php

include "connect_mysql.php";

$id = $_GET['id'];

$user_query = $connect->query("SELECT * FROM users where id=$id");
$user = $user_query->fetch_array();

if(isset($_POST['submit']))
{
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $education = $_POST["education"];
    $job_seeker = $_POST["job_seeker"];

    $stmt = $connect->prepare("UPDATE users SET name=?, email=?, phone=?, education=?, job_seeker=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $education, $job_seeker, $id);
    $stmt->execute();
    if($stmt)
    {
        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Felhasználó szerkesztése</title>
</head>
<body>
    <div class="container-fluid mt-4 wrapper">

        <form action="" method="post">

            <label for="name">Név</label>
            <input type="text" name="name" class="form-control" value="<?= $user['name']?>">

            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" value="<?= $user['email']?>" disabled>

            <label for="phone">Telefonszám</label>
            <input type="tel" name="phone" class="form-control" value="<?= $user['phone']?>">

            <label for="education">Iskolai végzettség</label>
            <select name="education" class="form-control">
                <option value="Egyetem" <?php if ($user['education'] == "Egyetem") echo "selected"; ?>>Egyetem</option>
                <option value="Főiskola" <?php if ($user['education'] == "Főiskola") echo "selected"; ?>>Főiskola</option>
                <option value="Középiskola" <?php if ($user['education'] == "Középiskola") echo "selected"; ?>>Középiskola</option>
                <option value="Szakközép iskola" <?php if ($user['education'] == "Szakközép iskola") echo "selected"; ?>>Szakközép iskola</option>
                <option value="Általános isklola"><?php if ($user['education'] == "Általános isklola") echo "selected"; ?>>Általános isklola</option>
            </select>


            <label for="job_seeker">Állástkeres</label>
            <select class="form-select" name="job_seeker"  value="<?= $user['job_seeker']?>">
                <option value="Igen">Igen</option>
                <option value="Nem">Nem</option>
            </select>

            <button type="submit" name ="submit" class="btn btn-dark mt-4">Mentés</button>

        </form>

    </div>
</body>
</html>
