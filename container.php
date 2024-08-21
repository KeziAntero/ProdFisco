<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="shortcut icon" href="./img/logo-prod.png"/>
    <meta charset="UTF-8">
    <title>ProdFisco</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>
    <link rel="stylesheet" href="./css/style.css">

</head>

<body>
    
    <!-- partial:index.partial.html -->
    <nav class="navbar navbar-expand-lg" style="background-color: #5EAC24;">
        <a href="prod_list.php" class="navbar-brand" style="color:#FFFFFF"> <img id="logo" src="./img/logo-prod-b.png" alt="Logo" style="float: left; width: 35px;">ProdFisco</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex justify-content-end" id="navbarSupportedContent">
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a style="color:#FFFFFF" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-copy"></i> Produtividade
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="gancho-config"></div>
                        <a class="dropdown-item" href="create_prod.php"><i class="fa fa-plus"></i> Criar Produtividade</a>
                        <a class="dropdown-item" href="prod_list.php"><i class="fa fa-list"></i> Listar Produtividades</a>

                    </div>
                </li>
            </ul>
          <span class="text-light text-center mr-2"> </span>
            <ul class="navbar-nav dropdown-menu-right">
                <?php
                if ($_SESSION['userid']) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF"> <i class="fa fa-user"></i> <?php echo $_SESSION['user']; ?></a>
                        <div class="dropdown-menu dropdown-usuario  mt-2" aria-labelledby="navbarDropdown">
                            <div class="gancho-config"></div>
                            <a class="dropdown-item" href="action.php?action=logout">
                                <i class="fa fa-sign-out-alt"></i>
                                Sair</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <!-- partial -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>