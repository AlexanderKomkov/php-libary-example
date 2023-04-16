<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактирование книги - Библиотека</title>
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
                    <a class="nav-link active" aria-current="page" href="/books">Книги</a>
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

<?php if(isset($book) && is_array($book) && !empty($book)): ?>
<div class="container my-5">
    <h1>Редактирование книги #<?=$book['id']?></h1>
    <a href="<?='/books/' . $book['id']?>" class="btn btn-success mb-5 mt-2">Назад к просмотру книги</a>
    <div class="col-lg-8 px-0">
        <?php if(isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach($_SESSION['errors'] as $error): ?>
            <?=$error . ' '?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        <form action="<?='/books/' . $book['id'] . '/update'?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Наименование</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Наименование книги" value="<?=$book['title']?>"  required>
            </div>
            <div class="mb-3">
                <label for="count" class="form-label">Количество</label>
                <input type="number" class="form-control" id="count" name="count" placeholder="Остаток" value="<?=$book['count']?>" required>
            </div>
            <?php if(isset($authors) && is_array($authors) && !empty($authors)): ?>
            <?php
                $author_ids = [];
                foreach ($book['authors'] as $author) {
                    $author_ids[] = $author['id'];
                }
            ?>
            <div class="mb-3">
                <label for="authors" class="form-label">Авторы</label>
                <select class="form-select" multiple aria-label="size 5 multiple select example" id="authots" name="authors[]" required>
                    <?php foreach($authors as $author): ?>
                    <option value="<?=$author['id']?>"<?=(in_array($author['id'], $author_ids) ? ' selected' : '')?>><?=$author['first_name'] . ' ' . $author['last_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <?php if(isset($genres) && is_array($genres) && !empty($genres)): ?>
            <?php
                $genre_ids = [];
                foreach ($book['genres'] as $genre) {
                    $genre_ids[] = $genre['id'];
                }
            ?>
            <div class="mb-3">
                <label for="genres" class="form-label">Жанры</label>
                <select class="form-select" multiple aria-label="size 5 multiple select example" id="genres" name="genres[]" required>
                    <?php foreach($genres as $genre): ?>
                    <option value="<?=$genre['id']?>"<?=(in_array($genre['id'], $genre_ids) ? ' selected' : '')?>><?=$genre['title']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Редактировать</button>
            </div>
        </form>
        <a href="https://github.com/AlexanderKomkov/php-libary-example" target="_blank" class="mt-5 btn btn-secondary">View on GitHub</a>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>