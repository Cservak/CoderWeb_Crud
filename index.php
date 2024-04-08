<?php 

include "connect_mysql.php";

function check_input()
{
    $name = isset($_POST["name"]) && !empty($_POST["name"]);
    $email = isset($_POST["email"]) && !empty($_POST["email"]);
    $phone = isset($_POST["phone"]) && !empty($_POST["phone"]);
    $education = isset($_POST["education"]) && !empty($_POST["education"]);
    $job_seeker =  isset($_POST["job_seeker"]) && !empty($_POST["job_seeker"]);
    return $name && $email && $phone && $education && $job_seeker;
}

function check_email($email)
{
    global $connect;
    $emails = $connect ->query("SELECT email FROM users WHERE email='$email'");
    while($current_email = $emails ->fetch_array())
    {
        if($current_email["email"] == $email)
        {
            return true;
        }
    }
    return false;
}

function crate_user()
{
    global $connect;

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $education = $_POST["education"];
    $job_seeker = $_POST["job_seeker"];

    if (check_email($email))
    {
        return;
    }

    $stmt = $connect ->prepare("INSERT INTO users (name, email, phone, education, job_seeker) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $education, $job_seeker]);
    if($stmt)
    {
        header("Location: index.php");
    }
}

function read_users()
{
    global $connect;

    $users = $connect ->query("SELECT id, name, email, phone, education, job_seeker FROM users");
    while($user = $users->fetch_array())
    {
        $table_body = <<<users
            <tr>
                <td>{$user["name"]}</td>
                <td>{$user["email"]}</td>
                <td>{$user["phone"]}</td>
                <td>{$user["education"]}</td>
                <td>{$user["job_seeker"]}</td>
                <td>
                    <a type="button" class="btn btn-danger" href="upgrad_user.php?id={$user["id"]}">Szerkeszt</a>
                    <a type="button" class="btn btn-dark ms-2" href="delete_user.php?id={$user["id"]}">Törlés</a>     
                </td>
            </tr>
        users;
        echo $table_body;
    }
}

if(check_input())
{
    crate_user();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Project</title>
</head>
<body>
    <div class="container-fluid mt-4 wrapper">
        <form action="index.php" method="post">

            <label for="name">Név</label>
            <input type="text" name="name" class="form-control">

            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control">

            <label for="phone">Telefonszám</label>
            <input type="tel" name="phone" class="form-control">

            <label for="education">Iskolai végzettség</label>
            <select class="form-select" name="education">
                <option value="Egyetem">Egyetem</option>
                <option value="Főiskola">Főiskola</option>
                <option value="Középiskola">Középiskola</option>
                <option value="Szakközép iskola">Szakközép iskola</option>
                <option value="Általános isklola">Általános iskola</option>
            </select>

            <label for="job_seeker">Állástkeres</label>
            <select class="form-select" name="job_seeker">
                <option value="Igen">Igen</option>
                <option value="Nem">Nem</option>
            </select>

            <button type="submit" class="btn btn-dark mt-4">Hozzáad</button>

        </form>

        <div class="table-responsive mt-4">

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Név</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefonsszám</th>
                    <th scope="col">Végzettség</th>
                    <th scope="col">Állástkeres</th>
                    <th scope="col">Műveletek</th>
                </tr>
            </thead>
            <tbody class="bg-warning">
                <?php read_users(); $connect->close()?>
            </tbody>
        </table>
        </div>
    </div>
</body>
