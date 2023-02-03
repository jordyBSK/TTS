<?php
$host = 'localhost';
$db   = 'tts';
$user = 'fady';
$pass = 'fadyfady';
$dsn = "pgsql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
session_start();
if (is_null($_SESSION['connected'])) {
    $_SESSION['connected'] = false;
}




function connect ($username, $password, $pdo): bool
{
    try {
        $stmt = $pdo->prepare("SELECT username, password FROM client WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            session_start();
            $_SESSION['connected'] = true;
            return true;
        }
        return false;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function disconnect () {
    $_SESSION['connected'] = false;
    header('Location: index.php');
}

function isConnected (): bool {
    return $_SESSION['connected'];
}