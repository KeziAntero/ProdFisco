<?php
session_start();

include 'Prod.php';
$prod = new Prod();
$prod->checkLoggedIn();

// Buscar os fiscais e os tipos de serviço
$fiscais = $prod->getFiscais();
$serviceTypes = $prod->getServiceTypes();

if (!empty($_POST['fiscal']) && $_POST['fiscal']) {
    $prod->saveProd($_POST);
    header("Location:prod_list.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="shortcut icon" href="./img/logo-prod.png"/>
    <title>Criar produtividade</title>
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
        });

            function calculateTotal() {
                let total = 0;
                document.querySelectorAll('.qtdfiscal').forEach((qtdfiscal, index) => {
                    const price = document.querySelectorAll('.price')[index];
                    const totalField = document.querySelectorAll('.total')[index];
                    const taskqtdfiscal = parseFloat(qtdfiscal.value) || 1; // Ensure qtdfiscal is a number
                    const subtotal = (parseFloat(price.value) / taskqtdfiscal) || 0;
                    totalField.value = subtotal.toFixed(2);
                    total += subtotal;
                });
                document.getElementById('totalAftertax').value = total.toFixed(2);
            }

            document.querySelectorAll('.qtdfiscal, .price').forEach(input => {
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
        
    </script>
</head>

<body>
    <?php include('container.php'); ?>
    <div class="container content-prod" style="font-family: Poppins, sans-serif;">
        <div class="cards">
            <div class="card-body"><br>
                <form action="" id="prod-form" method="post" class="prod-form" role="form" novalidate="">
                    <div class="load-animate animated fadeInUp">

                        <input id="currency" type="hidden" value="$">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><br>
                                <h2>Criar nova Produtividade</h2>
                            </div><br>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><br><br>
                                <div class="form-group">
                                    <select class="form-control" name="fiscal" id="fiscal">
                                        <option value="">Selecione o Fiscal</option>
                                        <?php
                                        foreach ($fiscais as $fiscal) {
                                            echo '<option value="' . $fiscal['nome'] . '" data-matricula="' . $fiscal['matricula'] . '">' . $fiscal['nome'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">

                                    <input type="number" class="form-control" name="matricula" id="matricula" placeholder="Matrícula">
                                </div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-condensed table-striped" id="prodItem">
                                    <tr style="color:#6E7482">
                                        <th width="2%">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th width="15%">Id do documento</th>
                                        <th width="30%">Tipo de serviço</th>
                                        <th width="13%">Qtd</th>
                                        <th width="13%">Qtd de fiscal</th>
                                        <th width="13%">Pontuação Parcial</th>
                                        <th width="16%">Pontuação Total</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
                                                <label class="custom-control-label" for="itemRow_1"></label>
                                            </div>
                                        </td>
                                        <td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
                                        <td>
                                            <select class="form-control serviceName" name="serviceName[]" id="serviceName_1">
                                                <option value="">Selecione o Tipo de Serviço</option>
                                                <?php
                                                foreach ($serviceTypes as $service) {
                                                    echo '<option value="' . $service['service_name'] . '" data-price="' . $service['service_value'] . '">' . $service['service_name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
                                        <td><input type="number" name="qtdfiscal[]" id="qtdfiscal_1" class="form-control qtdfiscal" autocomplete="off"></td>
                                        <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
                                        <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
                                    </tr>
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
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-8">
                                <h5>Anotações: </h5>
                                <div class="form-group">
                                    <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Suas Anotações"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="form-group mt-3 mb-3">
                                    <label>Total: &nbsp;</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text currency">Pontos</span>
                                        </div>
                                        <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
                                    <input data-loading-text="Salvando..." type="submit" name="prod_btn" value="Salvar" class="btn btn-success submit_btn prod-save-btm">
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