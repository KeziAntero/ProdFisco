<?php
session_start();
include 'Prod.php';
$prod = new Prod();
$prod->checkLoggedIn();
?>
<link rel="shortcut icon" href="./img/logo-prod.png"/>
<title>ProdFisco</title>
<script src="js/prod.js"></script>
<link href="./css/style.css" rel="stylesheet">
<?php include('container.php'); ?>
<div class="container" style="font-family: Poppins, sans-serif;"><br><br>
    <h2 class="title mt-5" style="text-align: center;">Lista de produtividade</h2><br><br><br>

    <?php
    // Configurar o formatador de data para português
    $fmt = new IntlDateFormatter(
        'pt_BR', // Localidade
        IntlDateFormatter::LONG, // Formato de data
        IntlDateFormatter::NONE, // Sem formato de hora
        'America/Sao_Paulo' // Fuso horário
    );

    // Configurar o formato personalizado
    $fmt->setPattern('MMM/yyyy'); // Formato desejado: jul/2024
    ?>

    <table id="data-table" class="table table-condensed table-hover table-striped" style="color:#747476;position: relative;">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Competência</th>
                <th>Data de criação</th>
                <th>Total de Pontos</th>
                <th  style="text-align: center;" >Imprimir</th>
                <th  style="text-align: center;">Editar</th>
                <th  style="text-align: center;">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $prodList = $prod->getProdList();
            foreach ($prodList as $prodDetails) {
                // Formatar competência
                $prodDate = $fmt->format(new DateTime($prodDetails["order_date"]));
                // Formatar data de criação
                $orderDate = date("d/M/Y, H:i:s", strtotime($prodDetails["order_date"]));
                echo '
          <tr>
            <td>' . htmlspecialchars($prodDetails["order_id"]) . '</td>
            <td>' . htmlspecialchars($prodDate) . '</td>
            <td>' . htmlspecialchars($orderDate) . '</td>
            <td>' . htmlspecialchars($prodDetails["order_total_after_tax"]) . '</td>
            <td><a href="print_prod.php?prod_id=' . htmlspecialchars($prodDetails["order_id"]) . '" title="Imprimir produtividade"><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button></a></td>
            <td><a href="edit_prod.php?update_id=' . htmlspecialchars($prodDetails["order_id"]) . '" title="Editar produtividade"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a></td>
            <td><a href="delete-prod.php?order_id=' . htmlspecialchars($prodDetails['order_id']) . '" title="Deletar produtividade"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a></td>
          </tr>
        ';
            }
            ?>
        </tbody>
    </table>
</div>

</body>

</html>