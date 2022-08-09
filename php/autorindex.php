<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../css/stylesheet.css" rel="stylesheet">
</head>
<body class="autorizationbody">

<div class="autorpanel">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Авторизация</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Регистрация</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Адрес электронной почты</label>
                    <input type="email" name="email" class="form-control" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <?php
                if (isset($_GET['msg']))
                {
                    if ($_GET['msg'] == 'wronglogin')
                    {
                        echo "<div class='error'><p>Пользователя с таким электронным адресом не существует</p></div>";
                    }
                    elseif ($_GET['msg'] == 'wrongpassword')
                    {
                        echo "<div class='error'><p>Неверный пароль</p></div>";
                    }
                }?>
                <button type="submit" name="autorsubmit" class="btn btn-primary">Войти</button>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form action="autorindex.php" method="POST">
                <div class="mb-2">
                    <label class="form-label">Имя пользователя</label>
                    <input type="name" class="form-control" name="nickname" aria-describedby="emailHelp" required pattern="^[a-zA-Z0-9]{3,}">
                    <label class="form-label" style="font-style:italic;font-size: 10px">Имя пользователя может содержать только буквы и цифры и обязано быть больше 3 символов</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control" required pattern="^[a-zA-Z0-9]{3,}">
                    <label class="form-label" style="font-style:italic;font-size: 10px">Пароль может содержать только буквы и цифры и обязан быть больше 3 символов</label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary" >Зарегистрироваться</button>
            </form>
        </div>
    </div>

    <?php if(isset($_POST['submit']))
    {
        $f=fopen("../db/UsersData.txt","a+t") or die("Ошибка,файл базы данных не найден!");
        fwrite($f,($_POST['nickname']."/".$_POST['email']."/".md5($_POST['password'])));
        fwrite($f,"\r\n");
        $create=fopen("../db/" .$_POST['nickname']. ".txt", "w+t");
        fclose($create);
        echo "<script>alert(\"Вы успешно зарегистрировались\");</script>";
        fclose($f);
    }?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>