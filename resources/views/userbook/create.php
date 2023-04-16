<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Добавление книги пользователю - Библиотека</title>
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
                    <a class="nav-link active" href="/userbooks">Книги пользователей</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1>Добавить книгу пользователю</h1>
    <a href="/userbooks" class="btn btn-success mb-5 mt-2">Назад к списку книг пользователей</a>
    <div class="col-lg-8 px-0">
        <?php if(isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach($_SESSION['errors'] as $error): ?>
            <?=$error . ' '?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        <form action="/userbooks" method="POST">
            <?php if(isset($books) && is_array($books) && !empty($books)): ?>
            <div class="mb-3">
                <label for="book" class="form-label">Книга</label>
                <select class="form-select" aria-label="select example" id="book" name="books_id" required>
                    <?php foreach($books as $book): ?>
                    <option value="<?=$book['id']?>"><?=$book['title']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <? endif; ?>
            <?php if(isset($users) && is_array($users) && !empty($users)): ?>
            <div class="mb-3">
                <label for="users" class="form-label">Пользователь</label>
                <select class="form-select" aria-label="select example" id="users" name="users_id" required>
                    <?php foreach($users as $user): ?>
                    <option value="<?=$user['id']?>"><?=$user['first_name'] . ' ' . $user['last_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <? endif; ?>
            <div class="mb-3">
                <label for="date" class="form-label">Дата</label>
                <input type="text" class="form-control" id="date" name="date" placeholder="2022-12-08" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>

        <a href="#" class="mt-5 btn btn-secondary">View on GitHub</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>