<?php

session_start();
$title = "login";
$style = "index.css";
require "../vendor/autoload.php";
require_once '../src/authentification.php';


if (isset($_POST['submit'])) {
    if(connect($_POST['username'], $_POST['password'], $pdo)) {
        header('Location: 3Dpage.php');
        exit();
    } else { ?>
        <div class="notification is-danger is-light">
            <button class="delete"></button>
        Authentification failed. The username and/or the password is not correct
        </div>
    <?php }
}


require_once '../src/header.php';

?>

    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                <div class="is-child box column is-8 is-offset-2">
                    <form action="login.php"
                          method="post">
                        <label for="first_name">Username<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="username"
                                   placeholder="Enter your username"
                                   required><br><br>
                        </label>
                        <label for="last_name">Password<br>
                            <input class="input is-normal"
                                   type="password"
                                   name="password"
                                   placeholder="Enter your password"
                                   required><br><br>
                        </label>
                        <input class="button is-primary is-outlined is-light"
                               id="submit_id"
                               type="submit"
                               name="submit"
                               value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
