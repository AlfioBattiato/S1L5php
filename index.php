<?php
$host = 'localhost';
$db = 'books';
$user = 'root';
$pass = '';
$array = [];
$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// comando che connette al database
$pdo = new PDO($dsn, $user, $pass, $options);
$search = $_GET['search'] ?? '';
$limit = 100;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit; // pagina 0
$stmt = $pdo->prepare("SELECT * FROM books WHERE titolo LIKE :search LIMIT :limit OFFSET :offset");
$stmt->execute([
    'search' => "%$search%",
    'offset' => $offset,
    'limit' => $limit,
]);
$array = $stmt->fetchAll();
$stmt = $pdo->query("SELECT count(*) AS numeroElementi FROM books   ");
$numeroElementi = $stmt->fetch()["numeroElementi"];

// validazione dei campi

$errors = [];
$errors2 = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") { //controllo se la richiesta è di tipo POST
    $titolo = $_POST['Titolo'];
    $autore = $_POST['Autore'];
    $annoPubblicazione = $_POST['AnnoPubblicazione'];
    $genere = $_POST['Genere'];
    $immagine = $_POST['Immagine'];
    $formid = $_POST['formid'];
    $myid = $_POST["id"];

    if ($formid === 'inserisci') {
        if (strlen($titolo) < 2 || strlen($titolo) > 60) {
            $errors['titolo'] = 'Il titolo deve contenere un valore tra 2 e 60 caratteri';
        }
        if (strlen($genere) < 2 || strlen($genere) > 50) {
            $errors['genere'] = 'Il genere deve contenere un valore tra 2 e 50 caratteri';
        }
        if (strlen($immagine) < 10 || !filter_var($immagine, FILTER_VALIDATE_URL)) {
            $errors['immagine'] = 'L\'URL dell\'immagine non è valido';
        }
        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO books (titolo, autore, anno_pubblicazione,genere,img) VALUES (:titolo, :autore, :anno_pubblicazione,:genere, :img)");
            $stmt->execute([
                'titolo' => $titolo,
                'autore' => $autore,
                'anno_pubblicazione' => $annoPubblicazione,
                'genere' => $genere,
                'img' => $immagine
            ]);
            header('Location: index.php');
        }
    } elseif ($formid === 'modifica') {
        if (strlen($titolo) < 2 || strlen($titolo) > 60) {
            $errors2['titolo'] = 'Il titolo deve contenere un valore tra 2 e 60 caratteri';
        }
        if (strlen($genere) < 2 || strlen($genere) > 50) {
            $errors2['genere'] = 'Il genere deve contenere un valore tra 2 e 50 caratteri';
        }
        if (strlen($immagine) < 10 || !filter_var($immagine, FILTER_VALIDATE_URL)) {
            $errors2['immagine'] = 'L\'URL dell\'immagine non è valido';
        }
        if (empty($errors2)) {
            $stmt = $pdo->prepare("UPDATE books SET titolo = :titolo, autore = :autore, anno_pubblicazione = :anno_pubblicazione,genere = :genere, img = :immagine WHERE id = :id");
            $stmt->execute([
                'id' => $myid,
                'titolo' => $titolo,
                'autore' => $autore,
                'anno_pubblicazione' => $annoPubblicazione,
                'genere' => $genere,
                'immagine' => $immagine
            ]);
            header('Location: index.php');
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Includi il file CSS delle icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar bg-body-tertiary red myn">
        <div class="container">
            <a href="http://localhost/S1L5php/index.php " class="text-decoration-none" > <span
                    class="navbar-brand mb-0 text-white ">Feltrinelli</span></a>
            <div class='d-flex gap-2'>
                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Aggiungi Libro
                </button>
                <a href="http://localhost/S1L5php/login.php" class="fw-bold text-primary">Accedi</a>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Inserisci nuovo libro</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- form aggiungi libro -->
                            <div class="modal-body">

                                <form method="post" action="">
                                    <input type="hidden" name="formid" value="inserisci">
                                    <input type="hidden" name="id" value="">
                                    <div class="mb-3">
                                        <label for="Titolo" class="form-label">Titolo</label>
                                        <input type="text" value="<?php echo isset($titolo) ? $titolo : '' ?>"
                                            name="Titolo" class="form-control" id="Titolo">
                                        <?php echo isset($errors["titolo"]) ? "<div class='text-danger'>$errors[titolo]</div>" : "" ?>

                                    </div>
                                    <div class="mb-3">
                                        <label for="Autore" class="form-label">Autore</label>
                                        <input type="text" value="<?php echo isset($autore) ? $autore : '' ?>"
                                            name="Autore" class="form-control" id="Autore">
                                    </div>
                                    <div class="mb-3">
                                        <label for="AnnoPubblicazione" class="form-label">Anno Pubblicazione</label>
                                        <input type="date"
                                            value="<?php echo isset($annoPubblicazione) ? $annoPubblicazione : '' ?>"
                                            name="AnnoPubblicazione" class="form-control" id="AnnoPubblicazione">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Genere" class="form-label">Genere</label>
                                        <input type="text" value="<?php echo isset($genere) ? $genere : '' ?>"
                                            name="Genere" class="form-control" id="Genere">
                                        <?php echo isset($errors["genere"]) ? "<div class='text-danger'>$errors[genere]</div>" : "" ?>

                                    </div>
                                    <div class="mb-3">
                                        <label for="Immagine" class="form-label">Immagine</label>
                                        <input type="text" value="<?php echo isset($immagine) ? $immagine : '' ?>"
                                            name="Immagine" class="form-control" id="Immagine">
                                        <?php echo isset($errors["immagine"]) ? "<div class='text-danger'>$errors[immagine]</div>" : "" ?>

                                    </div>
                                    <button type="submit" class="btn btn-primary" id="submitButton">Inserisci</button>
                                    <div id="errorDiv" class="text-danger mt-2"></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </nav>
    <!-- -------------------------------------------main -->
    <!-- header -->
    <div class="container-fluid">
        <div class="d-flex gap-2 justify-content-center align-items-center py-5">
            <img alt="img" class="img-fluid" src="logo.png" />
            <form class="d-flex" role="search" action="" method="get">
                <input class="form-control me-2 grey" type="search" placeholder="Cerca titolo libro" name="search"
                    aria-label="Cerca">
                <button class="btn btn-secondary" type="submit">Cerca</button>
            </form>
            <a href=""> <i class="bi bi-person-check fs-1 ms-5"></i></a>
        </div>
        <img alt="img" style="max-with:100%" class="img-fluid" src="feltrinelli.png" />
    </div>
    <div class="container-fluid px-5 pt-5">

        <main>
            <div class="row gy-3">

                <!-- main -->
                <?php foreach ($array as $key => $row): ?>
                    <div class="col col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="card" style="width: 100%;">
                            <img src="<?= $row['img'] ?>" class="card-img-top object-fit-cover" height="250rem" width="100%"
                                alt="Immagine">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['titolo'] ?></h5>
                                <h6>Autore: <span class="badge text-bg-dark"><?= $row['autore'] ?></span></h6>
                                <p class="card-text">Anno pubblicazione: <?= $row['anno_pubblicazione'] ?></p>
                                <h6>Genere: <span class="badge text-bg-primary"><?= $row['genere'] ?></span></h6>

                                <a href="" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal2<?= $key ?>" id="btn-modifica<?= $row["id"]?>">Modifica</a>
                                <a href="http://localhost/S1L5php/delete.php?id=<?= $row['id'] ?>"
                                    class="btn btn-danger red">Elimina</a>
                            </div>
                        </div>
                        <div class="modal fade "
                             id="exampleModal2<?= $key ?>"
                            tabindex="-1" aria-labelledby="exampleModalLabel<?= $key ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel<?= $key ?>">Form Modifica</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form modifica -->
                                        <form method="post" action="">
                                            <input type="hidden" name="formid" value="modifica">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <?php echo isset($errors2["titolo"]) ? "<div class='text-danger'>$errors2[titolo]</div>" : "" ?>


                                            <div class="mb-3">
                                                <label for="Titolo" class="form-label">Titolo</label>
                                                <input value="<?= $row['titolo'] ?>" type="text" name="Titolo"
                                                    class="form-control" id="Titolo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Autore" class="form-label">Autore</label>
                                                <input value="<?= $row['autore'] ?>" type="text" name="Autore"
                                                    class="form-control" id="Autore">
                                            </div>
                                            <div class="mb-3">
                                                <label for="AnnoPubblicazione" class="form-label">Anno Pubblicazione</label>
                                                <input value="<?= $row['anno_pubblicazione'] ?>" type="date"
                                                    name="AnnoPubblicazione" class="form-control" id="AnnoPubblicazione">
                                            </div>
                                            <div class="mb-3">
                                                <label for="genere" class="form-label">Genere</label>
                                                <input value="<?= $row['genere'] ?>" type="text" name="Genere"
                                                    class="form-control" id="genere">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Immagine" class="form-label">Immagine</label>
                                                <input value="<?= $row['img'] ?>" type="text" name="Immagine"
                                                    class="form-control" id="Immagine">
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                id="submitButton">Modifica</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

    </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Script per gestire l'apertura del modale -->
    <script>
        <?php if (!empty($errors)): ?>
            $(document).ready(function () {
                $('#exampleModal').modal('show');
            });
        <?php endif; ?>
      
        <?php if (!empty($errors)): ?>
            document.querySelector("#btn-modifica<?= $myid?>").click();

        <?php endif; ?>
      

    </script>


</body>

</html>