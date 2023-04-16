<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Список атворов - Библиотека</title>
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

<div class="container my-5">
    <h1>Авторы</h1>
    <a href="/authors/create" class="btn btn-success mb-5 mt-2">Добавить автора</a>
    <div class="col-lg-8 px-0">

        <?php if(isset($authors) && is_array($authors) && !empty($authors)): ?>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th scope="col">Просмотр</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($authors as $author): ?>
            <tr>
                <th scope="row"><?=$author['id']?></th>
                <td><?=$author['first_name']?></td>
                <td><?=$author['last_name']?></td>
                <td>
                    <a href="<?='/authors/' . $author['id']?>" type="button" class="btn btn-primary">Просмотр</a>
                </td>
                <td>
                    <a href="<?='/authors/' . $author['id'] . '/edit'?>" type="button" class="btn btn-success">Редактировать</a>
                </td>
                <td>
                    <form action="<?='/authors/' . $author['id'] . '/destroy'?>" method="POST">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php else: ?>

        <p>В настоящий момент, к сожалению, авторов книг нет.</p>

        <?php endif; ?>

        <a href="https://github.com/AlexanderKomkov/php-libary-example" target="_blank" class="mt-5 btn btn-secondary">View on GitHub</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>