<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../css/stylesheet.css" rel="stylesheet">
    <meta charset="utf-8">
    <?php
    if(isset($_POST['autorsubmit']))
    {
        $f=fopen("../db/UsersData.txt","a+t") or die("Ошибка,файл базы данных не найден!");
        while(!feof($f))
        {
            $str=fgets($f);
            if (str_contains($str, $_POST['email']))
            {
                $arr = explode("/", $str,3);
                list ($nickname,$mail,$password) =$arr;
                if (str_contains($password,md5($_POST['password'])))
                {
                    echo "<script>alert(\"Добро пожаловать,$nickname\");</script>";
                    setcookie("nick",$nickname);
                    break;
                }
                else
                {
                    header("Location: autorindex.php?msg=wrongpassword");
                    exit;
                }
            }
            elseif(feof($f))
            {
                echo "<script>alert(\"FE\");</script>";
                fclose($f);
                header("Location: autorindex.php?msg=wronglogin");
                exit;
            }
        }
    }
    if(isset($_POST['booksubm']))
    {
        $g=fopen("../db/".$_COOKIE['nick'].".txt","a+t") or die("Ошибка,файл базы данных не найден!");
        fwrite($g,(@$_POST['title']."/".@$_POST['year']));
        fwrite($g,"\r\n");
        fclose($g);
    }
    if(isset($_POST['exit']))
    {
        setcookie("nick",'',time()-3600);
    }
    ?>
</head>
<body class="indexbody">
<header>
    <div class="row" >
        <div class="col" style="padding-top: 10px">
            <img src="img/library.svg" id="logo">
        </div>
        <div class="col"style="padding-top: 75px">
            <div class="searchdiv">
                <div class="container-fluid">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Поиск книги" aria-label="Search">
                        <button class="btn btn-primary btn-sm" type="submit">Поиск</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <?php
            if(!isset($_POST['autorsubmit']))
            {
                echo '<button type="button" class="enterbutton" >
                <a href="autorindex.php"> Войти <img src="img/autor.svg"> </a>
            </button>';
            }
            else
            {
                echo '<div class="buttons"><button type="button" style="margin-right: 40px" class="autorbutton" data-bs-toggle="modal" data-bs-target="#exampleModal">
                 Добавить <img class="iconcls" src="img/addbook.svg">
            </button>';
                echo '<form method="POST"><button type="button" name="exit" class="exitbutton">
                <a href="index.php"> Выйти <img class="iconcls" src="img/autor.svg"></a>
            </button></form></div>';

            }
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Добавить книгу</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="index.php" method="POST">
                            <div class="mb-3">
                                <label  class="form-label">Год выпуска</label>
                                <input type="text" name="year" class="form-control" style="width:100px">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">Название книги</label>
                                <input type="text" name="title" class="form-control" style="width:250px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="booksubm" class="btn btn-primary">Добавить</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="maindiv">
    <div class="caption">
        <?php if(isset($_POST['autorsubmit']))
        { echo'<h1>Ваши книги, '.$_COOKIE['nick'].' </h1>'; } ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                    <?php
                    if(isset($_POST['autorsubmit'])) {
                        $booksfile = fopen("../db/" . $_COOKIE['nick'] . ".txt", "rt") or die("Ошибка,файл базы данных не найден!");
                        while (!feof($booksfile)) {
                            $data = fgets($booksfile);
                            if ($data != "") {
                                $bookarr = explode("/", $data, 2);
                                list ($booktitle, $bookyear) = $bookarr;
                                echo ' 
                        <div class="book">
                             <div class="image">
                                  <img src="img/test.png" id="img">
                             </div>
                             <div class="info">
                                  <div class="title">
                                       <b>' . $booktitle . '</b>
                                  </div>
                                  <div class="year">
                                       Год выпуска: <i>' . $bookyear . ' г.</i>
                                  </div>
                             </div>
                        </div>';
                            }
                        }
                    }?>
            </div>
            <div class="col-6 col-md-4">
                <div class="panel">
                    <div class="dropdown">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio1" style="border: 0px">сортировка по имени</label>
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2" style="border: 0px">сортировка по году выпуску</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>