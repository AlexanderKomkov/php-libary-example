<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Редактирование автора - Библиотека</title>
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
                    <a class="nav-link active" aria-current="page" href="/authors">Авторы</a>
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

<?php if(isset($author) && is_array($author) && !empty($author)): ?>
<div class="container my-5">
    <h1>Редактирование автора #<?=$author['id']?></h1>
    <a href="<?='/authors/' . $author['id']?>" class="btn btn-success mb-5 mt-2">Назад к просмотру автора</a>
    <div class="col-lg-8 px-0">
        <?php if(isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach($_SESSION['errors'] as $error): ?>
            <?=$error . ' '?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        <form action="<?='/authors/' . $author['id'] . '/update'?>" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Иван" value="<?=$author['first_name']?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Иванов" value="<?=$author['last_name']?>" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Редактировать</button>
            </div>
        </form>
        <a href="#" class="mt-5 btn btn-secondary">View on GitHub</a>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>