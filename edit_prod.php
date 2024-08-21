<?php
session_start();
include 'Prod.php';

$prod = new Prod();
$prod->checkLoggedIn();
if (!empty($_POST['fiscal']) && $_POST['fiscal'] && !empty($_POST['prodId']) && $_POST['prodId']) {
    $prod->updateProd($_POST);
    header("Location:prod_list.php");
}
if (!empty($_GET['update_id']) && $_GET['update_id']) {
    $prodValues = $prod->getProd($_GET['update_id']);
    $prodItems = $prod->getProdItems($_GET['update_id']);
    $serviceTypes = $prod->getServiceTypes();
}
?>
<!DOCTYPE html>
<html>

<head>
<link rel="shortcut icon" href="./img/logo-prod.png"/>
    <title>Editar produtividade</title>
    <link href="./css/style.css" rel="stylesheet">

    <script>
         document.addEventListener('DOMContentLoaded', function() {
        function calculateTotal() {
            let grandTotal = 0;

            document.querySelectorAll('.qtdfiscal').forEach((qtdfiscal, index) => {
                const price = document.querySelectorAll('.price')[index];
                const quantity = document.querySelectorAll('.quantity')[index];
                const totalField = document.querySelectorAll('.total')[index];

                const qty = parseFloat(quantity.value) || 0; // Quantidade
                const priceValue = parseFloat(price.value) || 0; // Preço
                const fiscalQty = parseFloat(qtdfiscal.value) || 1; // Quantidade de fiscais

                const subtotal = (qty * priceValue) / fiscalQty; // Subtotal ajustado pela quantidade de fiscais
                totalField.value = subtotal.toFixed(2);
                grandTotal += subtotal;
            });

            document.getElementById('totalAftertax').value = grandTotal.toFixed(2);
        }

            // Adiciona evento de input aos campos de quantidade, preço e quantidade de fiscais
            document.querySelectorAll('.quantity, .qtdfiscal, .price').forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            document.getElementById('addRows').addEventListener('click', () => {
                const table = document.getElementById('prodItem');
                const rowCount = table.rows.length;
                const row = table.insertRow(rowCount);
                row.innerHTML = `
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="itemRow custom-control-input" id="itemRow_${rowCount}">
                        <label class="custom-control-label" for="itemRow_${rowCount}"></label>
                    </div>
                </td>
                <td><input type="text" name="productCode[]" id="productCode_${rowCount}" class="form-control" autocomplete="off"></td>
                <td>
                    <select class="form-control serviceName" name="serviceName[]" id="serviceName_${rowCount}">
                        <option value="">Selecione o Tipo de Serviço</option>
                        <?php
                        foreach ($serviceTypes as $service) {
                            echo '<option value="' . $service['service_name'] . '" data-price="' . $service['service_value'] . '">' . $service['service_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td><input type="number" name="quantity[]" id="quantity_${rowCount}" class="form-control quantity" autocomplete="off"></td>
                <td><input type="number" name="qtdfiscal[]" id="qtdfiscal_${rowCount}" class="form-control qtdfiscal" autocomplete="off"></td>
                <td><input type="number" name="price[]" id="price_${rowCount}" class="form-control price" autocomplete="off"></td>
                <td><input type="number" name="total[]" id="total_${rowCount}" class="form-control total" autocomplete="off"></td>`;
                document.getElementById(`qtdfiscal_${rowCount}`).addEventListener('input', calculateTotal);
                document.getElementById(`price_${rowCount}`).addEventListener('input', calculateTotal);
                document.getElementById(`quantity_${rowCount}`).addEventListener('input', calculateTotal);

                // Event listener para alterar o preço ao selecionar um tipo de serviço
                document.getElementById(`serviceName_${rowCount}`).addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const priceField = document.getElementById(`price_${rowCount}`);
                    priceField.value = price;
                    calculateTotal();
                });
            });

            document.getElementById('removeRows').addEventListener('click', () => {
                document.querySelectorAll('.itemRow:checked').forEach(row => {
                    row.closest('tr').remove();
                    calculateTotal();
                });
            });

            // Atualizar matrícula do fiscal ao selecionar o fiscal
            document.getElementById('fiscal').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const matricula = selectedOption.getAttribute('data-matricula');
                document.getElementById('matricula').value = matricula;
            });

            // Inicializar os preços dos tipos de serviço já existentes
            document.querySelectorAll('.serviceName').forEach(serviceName => {
                serviceName.addEventListener('change', function() {
                    const price = this.options[this.selectedIndex].getAttribute('data-price');
                    const rowId = this.id.split('_')[1];
                    document.getElementById(`price_${rowId}`).value = price;
                    calculateTotal();
                });
            });

            calculateTotal();
    
            // Botão de cancelar
            document.getElementById('cancelBtn').addEventListener('click', function() {
                window.location.href = 'prod_list.php'; // Redireciona para a página inicial
            });
        });
    </script>
</head>

<body>

    <?php include('container.php'); ?>
    <div class="container content-prod">
        <div class="cards">
            <div class="card-bodys">
                <form action="" id="prod-form" method="post" class="prod-form" role="form" novalidate="">
                    <div class="load-animate animated fadeInUp">
                        <div class="row">
                            <div class="col-xs-12"><br><br><br>
                                <h1 class="title">Editar Produtividade</h1>
                            </div>
                        </div>
                        <input id="currency" type="hidden" value="$">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <input value="<?php echo htmlspecialchars($prodValues['order_receiver_name']); ?>" type="text" class="form-control" name="fiscal" id="fiscal" placeholder="Nome do Fiscal" autocomplete="off">
                                </div>
                                <div class="form-group" style="font-weight: 400;font-style: normal;">
                                    <input value="<?php echo htmlspecialchars($prodValues['order_receiver_matricula']); ?>" class="form-control" name="matricula" id="matricula" placeholder="Matrícula"></input>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-condensed table-striped" id="prodItem">
                                    <tr style="color:#6E7482">
                                        <th width="5%">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th width="13%">Id do documento</th>
                                        <th width="35%">Tipo de serviço</th>
                                        <th width="11%">Qtd</th>
                                        <th width="11%">Qtd de Fiscal</th>
                                        <th width="12%">Pontuação Parcial</th>
                                        <th width="16%">Pontuação Total</th>
                                    </tr>
                                    <?php
                                    $count = 0;
                                    foreach ($prodItems as $prodItem) {
                                        $count++;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input itemRow" id="itemRow_<?php echo $count; ?>">
                                                    <label class="custom-control-label" for="itemRow_<?php echo $count; ?>"></label>
                                                </div>
                                            </td>
                                            <td><input type="text" value="<?php echo htmlspecialchars($prodItem["item_code"]); ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" autocomplete="off"></td>
                                            <td>
                                                <select class="form-control serviceName" name="serviceName[]" id="serviceName_<?php echo $count; ?>">
                                                    <option value="">Selecione o Tipo de Serviço</option>
                                                    <?php
                                                    foreach ($serviceTypes as $service) {
                                                        $selected = ($service['service_name'] == $prodItem['item_name']) ? 'selected' : '';
                                                        echo '<option value="' . htmlspecialchars($service['service_name']) . '" data-price="' . htmlspecialchars($service['service_value']) . '" ' . $selected . '>' . htmlspecialchars($service['service_name']) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="number" value="<?php echo htmlspecialchars($prodItem["order_item_quantity"]); ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" class="form-control quantity" autocomplete="off"></td>
                                            <td><input type="number" value="<?php echo htmlspecialchars($prodItem["order_item_qtdfiscal"]); ?>" name="qtdfiscal[]" id="qtdfiscal_<?php echo $count; ?>" class="form-control qtdfiscal" autocomplete="off"></td>
                                            <td><input type="number" value="<?php echo htmlspecialchars($prodItem["order_item_price"]); ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" autocomplete="off"></td>
                                            <td><input type="number" value="<?php echo htmlspecialchars($prodItem["order_item_final_amount"]); ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" autocomplete="off"></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="margin: 0 8px;">
                            <div class="col-xs-12" style="margin: 0px 5px;">
                                <button class="btn btn-success" id="addRows" type="button" title="Adicionar serviço">+ Adicionar serviço</button>
                            </div>
                            <div class="col-xs-12">
                                <button class="btn btn-danger delete" id="removeRows" type="button" title="Excluir serviço">- excluir serviço</button>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <h5>Anotações: </h5>
                                <div class="form-group">
                                    <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Suas anotações"><?php echo htmlspecialchars($prodValues['note']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group mt-3 mb-3">
                                    <label>Total: &nbsp;</label>
                                    <div class="input-group">
                                        <div class="input-group-append currency"><span class="input-group-text">Pontos</span></div>
                                        <input value="<?php echo htmlspecialchars($prodValues['order_total_after_tax']); ?>" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="<?php echo htmlspecialchars($_SESSION['userid']); ?>" class="form-control" name="userId">
                                    <input type="hidden" value="<?php echo htmlspecialchars($prodValues['order_id']); ?>" class="form-control" name="prodId" id="prodId">
                                    <input data-loading-text="Updating Prod..." type="submit" name="prod_btn" value="Salvar edição" class="btn btn-success submit_btn prod-save-btm" title="Salvar Produtividade">
                                    <!-- Botão Cancelar -->
                                    <button type="button" id="cancelBtn" class="btn btn-secondary" title="Cancelar Produtividade">Cancelar</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>