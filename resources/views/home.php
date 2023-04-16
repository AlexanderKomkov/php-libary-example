<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Библиотека</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Библиотека</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/books">Книги</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/authors">Авторы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/genres">Жанры</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users">Пользователи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/userbooks">Книги пользователей</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1>Добро пожаловать в библиотеку!</h1>
    <div class="col-lg-11 px-0">
        <?php if(isset($books) && is_array($books) && !empty($books)): ?>
        <p class="fs-5">Наши книги, которые можно почитать:</p>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Наименование</th>
                <th scope="col">Авторы</th>
                <th scope="col">Жанры</th>
                <th scope="col">Количество</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <th scope="row"><?=$book['id']?></th>
                <td><?=$book['title']?></td>
                <?php
                    $authors = [];
                    foreach ($book['authors'] as $author) {
                        $authors[] = $author['first_name'] . ' ' . $author['last_name'];
                    }
                ?>
                <td><?=implode(', ', $authors)?></td>
                <?php
                    $genres = [];
                    foreach ($book['genres'] as $genre) {
                        $genres[] = $genre['title'];
                    }
                ?>
                <td><?=implode(', ', $genres)?></td>
                <td><?=$book['count']?> шт.</td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php else: ?>

        <p>В настоящий момент, к сожалению, почитать нечего.</p>

        <?php endif; ?>

        <a href="" class="mt-5 btn btn-secondary">View on GitHub</a>
        <a href="/books" class="btn btn-success mt-5">Панель управления</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>