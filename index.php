<?php
include __DIR__ . '/includes/get.php';

$errors = [];
$errors2 = [];


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $formid = $_POST['formid'];

    if ($formid === 'registrazione') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email non valida';
        }
        if (strlen($password) < 0) {
            $errors['password'] = 'La password deve contenere almeno 2 caratteri';
        }
        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->execute([
                'email' => $email,
                'password' =>  password_hash($password, PASSWORD_DEFAULT)
            ]);
            $success = true;
        }
    } elseif ($formid === 'login') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors2['email'] = 'Email non valida';
        }
        if (strlen($password) < 0) {
            $errors2['password'] = 'La password deve contenere almeno 8 caratteri';
        }
        if (empty($errors2)) {
            //chiamata fetch al mio db
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email LIKE :email");
            $stmt->execute([
                'email' => $_POST["email"],
              
            ]);
            
            $user = $stmt->fetch();
            if($user){

                if(password_verify($_POST['password'],$user['password'])){//questo if controlla se la password è corretta ovvero il mio pass verify ritorna true se sono uguali altrimenti false
                    session_start();
                    $_SESSION['email'] = $user['email'];
                    // echo('tutto bene');
                    header("Location:home.php?utente=$email");
                
                }else{
                    echo ('qualcosa non va');
                    $insuccess = true;
                }
            }else{
                echo ('qualcosa non va');
                $insuccess = true;
            }

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar bg-body-tertiary red myn">
        <div class="container">
            <span class="navbar-brand mb-0 text-white ">Feltrinelli</span>
            <img alt="img" style="with:100%" class="img-fluid" src="feltrinelli.png" />
        </div>
    </nav>

    <h1 class="text-center mt-3">Benvenuto nel nostro sito</h1>


    
    <?php if (isset($success)): ?>
        <p class='text-primary text-center fw-bold'>Registrazione effettuata con successo! Fai il login per proseguire</p>
    <?php endif; ?>




    <?php if (isset($insuccess)): ?>
        <p class='text-danger text-center fw-bold'>Attenzione email o password non corretta</p>
    <?php endif; ?>

    <div class="container mt-5 d-flex gap-2 justify-content-center align-items-center py-5">
        <!-- login -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Accedi
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="registrazione">Accedi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="formid" value="login">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1_login"
                                    aria-describedby="emailHelp">
                                <?php if (isset($errors2['email'])): ?>
                                    <div class="text-danger"><?php echo $errors2['email']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    id="exampleInputPassword1_login">
                                <?php if (isset($errors2['password'])): ?>
                                    <div class="text-danger"><?php echo $errors2['password']; ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-success">Accedi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- registrati -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
            Registrati
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="registrazione">Accedi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="formid" value="registrazione">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1_login"
                                    aria-describedby="emailHelp">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="text-danger"><?php echo $errors['email']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    id="exampleInputPassword1_login">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="text-danger"><?php echo $errors['password']; ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-success">Registrati</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>