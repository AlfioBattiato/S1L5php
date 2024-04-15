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
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit; // pagina 0

// $stmt = $pdo->query('SELECT * FROM pizza');
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
if ($_SERVER['REQUEST_METHOD'] == "POST") { //controllo se la richiesta è di tipo POST
    $titolo = $_POST['Titolo'];
    $autore = $_POST['Autore'];
    $annoPubblicazione = $_POST['AnnoPubblicazione'];
    $genere = $_POST['Genere'];
    $immagine = $_POST['Immagine'];
    $errors = [];
    //il filter var è un metodo di validazione nativo di php

    if (strlen($titolo) < 8) {
        $errors['titolo'] = 'La password deve contenere almeno 8 caratteri';
    }
    if ($errors == []) {
        
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
    echo '<pre>' . print_r($errors, true) . '</pre>';
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
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar bg-body-tertiary red myn">
        <div class="container">
            <span class="navbar-brand mb-0 text-white ">Feltrinelli</span>
            <div class='d-flex gap-2'>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Aggiungi Libro
                </button>

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
                                <form method="post" action="http://localhost/S1L5php/form.php">
                                    <div class="mb-3">
                                        <label for="Titolo" class="form-label">Titolo</label>
                                        <input type="text" name="Titolo" class="form-control" id="Titolo">
                                        <?php echo isset($titolo["titolo"]) ? "<div class='text-danger'>$errors[titolo]</div>" : "" ?>

                                    </div>
                                    <div class="mb-3">
                                        <label for="Autore" class="form-label">Autore</label>
                                        <input type="text" name="Autore" class="form-control" id="Autore">
                                    </div>
                                    <div class="mb-3">
                                        <label for="AnnoPubblicazione" class="form-label">Anno Pubblicazione</label>
                                        <input type="date" name="AnnoPubblicazione" class="form-control"
                                            id="AnnoPubblicazione">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Genere" class="form-label">Genere</label>
                                        <input type="text" name="Genere" class="form-control" id="Genere">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Immagine" class="form-label">Immagine</label>
                                        <input type="text" name="Immagine" class="form-control" id="Immagine">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Inserisci</button>
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
            <i class="bi bi-person-check fs-1 ms-5"></i>
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
                                    data-bs-target="#exampleModal<?= $key ?>">Modifica</a>
                                <a href="http://localhost/S1L5php/delete.php?id=<?= $row['id'] ?>"
                                    class="btn btn-danger">Elimina</a>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal<?= $key ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel<?= $key ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel<?= $key ?>">Form Modifica</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form modifica -->
                                        <form method="post"
                                            action="http://localhost/S1L5php/modifica.php?id=<?= $row['id'] ?>">
                                            <div class="mb-3">
                                                <label for="Titolo" class="form-label">Titolo</label>
                                                <input value=<?= $row['titolo'] ?> type="text" name="Titolo"
                                                    class="form-control" id="Titolo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Autore" class="form-label">Autore</label>
                                                <input value=<?= $row['autore'] ?> type="text" name="Autore"
                                                    class="form-control" id="Autore">
                                            </div>
                                            <div class="mb-3">
                                                <label for="AnnoPubblicazione" class="form-label">Anno Pubblicazione</label>
                                                <input value=<?= $row['anno_pubblicazione'] ?> type="date"
                                                    name="AnnoPubblicazione" class="form-control" id="AnnoPubblicazione">
                                            </div>
                                            <div class="mb-3">
                                                <label for="genere" class="form-label">Genere</label>
                                                <input value=<?= $row['genere'] ?> type="text" name="Genere"
                                                    class="form-control" id="genere">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Immagine" class="form-label">Immagine</label>
                                                <input value=<?= $row['img'] ?> type="text" name="Immagine"
                                                    class="form-control" id="Immagine">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Modifica</button>
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
    <script>
        console.log(<?php echo json_encode($array); ?>);
    </script>
</body>

</html>

<!-- colonna lista left
   <div class="col col-12 col-md-8">
                <h1>My booksList</h1>
                <div class="row border mb-3">
                    <div class="col col-12 col-md-3">
                        <p class="text-center fw-bold">Titolo</p>
                    </div>
                    <div class="col col-12 col-md-3">
                        <p class="text-center fw-bold">Autore</p>
                    </div>
                    <div class="col col-12 col-md-2">
                        <p class="text-center fw-bold">Anno pubblicazione</p>
                    </div>
                    <div class="col col-12 col-md-3">
                        <p class="text-center fw-bold">Genere</p>
                    </div>
                </div>

                <?php foreach ($array as $key => $row): ?>
                    <div class="row border">
                        <div class="col col-12 col-md-3">
                            <p class="text-center fw-semibold"><?php echo $row['titolo'] ?></p>
                        </div>

                        <div class="col col-12 col-md-3">
                            <p class="text-center fw-semibold"><?= $row['autore'] ?></p>
                        </div>

                        <div class="col col-12 col-md-3">
                            <p class="text-center fw-semibold"><?= $row['anno_pubblicazione'] ?></p>
                        </div>

                        <div class="col col-12 col-md-3">
                            <p class="text-center fw-semibold"><?= $row['genere'] ?></p>
                        </div>
                     

                    </div>
                <?php endforeach; ?>

            </div> -->