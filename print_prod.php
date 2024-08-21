<?php
session_start();
include 'Prod.php';
$prod = new Prod();
$prod->checkLoggedIn();

if (!empty($_GET['prod_id']) && $_GET['prod_id']) {
    $prodValues = $prod->getProd($_GET['prod_id']);
    $prodItems = $prod->getProdItems($_GET['prod_id']);

    $fmt = new IntlDateFormatter(
        'pt_BR',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'America/Sao_Paulo'
    );

    $fmt->setPattern('MMMM/yyyy');

    $prodDate = date("d/M/Y", strtotime($prodValues['order_date']));
    $prodMonth = $fmt->format(new DateTime($prodValues['order_date']));

    $output = '';

    $output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td id="header" colspan="2" align="center" style="font-size:18px; font-family: Courier Prime, monospace !important;">
                <img id="logo" src="./img/logo.png" alt="Logo" style="float: left; width: 100px; margin-right: 20px;">
                <b>PREFEITURA MUNICIPAL DE NOVA CRUZ<br>
                SECRETARIA MUNICIPAL DE TRIBUTAÇÃO E ARRECADAÇÃO<br><br>
                RELATÓRIO DE PRODUTIVIDADE</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" cellpadding="5">
                    <tr>
                        <td width="70%">
                            <br>
                            Fiscal: ' . htmlspecialchars($prodValues['order_receiver_name']) . '<br />
                            Matrícula: ' . htmlspecialchars($prodValues['order_receiver_matricula']) . '<br /><br>
                        </td>
                        <td width="30%">
                            Competência: ' . htmlspecialchars($prodMonth) . '<br>
                            Data de emissão: ' . htmlspecialchars($prodDate) . '<br />
                        </td>
                    </tr>
                </table>
                <br />
                <table width="100%" border="1" cellpadding="6" cellspacing="0">
                    <tr>
                        <th width="3%" align="left">No. Item</th>
                        <th width="8%" align="center">Id do documento</th>
                        <th width="20%" align="left">Tipo de serviço</th>
                        <th width="3%" align="center">Qtd</th>
                        <th width="5%" align="center">Qtd fiscais</th>
                        <th width="8%" align="left">Pontuação parcial</th>
                        <th width="8%" align="left">Pontuação Total</th> 
                    </tr>';

    $count = 0;
    foreach ($prodItems as $prodItem) {
        $count++;
        $output .= '
        <tr>
            <td align="center">' . htmlspecialchars($count) . '</td>
            <td align="left">' . htmlspecialchars($prodItem["item_code"]) . '</td>
            <td align="left">' . htmlspecialchars($prodItem["item_name"]) . '</td>
            <td align="center">' . htmlspecialchars($prodItem["order_item_quantity"]).'</td>
            <td align="center">' . htmlspecialchars($prodItem["order_item_qtdfiscal"]) . '</td>
            <td align="right">' . htmlspecialchars($prodItem["order_item_price"]) . '</td>
            <td align="right">' . htmlspecialchars($prodItem["order_item_final_amount"]) . '</td>
        </tr>';
    }

        $output .= '
            <tr>
                <td align="right" colspan="6"><b>Total: <b></td>
                <td align="right"><b>' . htmlspecialchars($prodValues['order_total_after_tax']) . '<b></td>
            </tr>
        </table>
        </td>
        
        </tr>
        <tr>
            <td colspan="2" align="left"><b>Anotações: </b>' . nl2br(htmlspecialchars($prodValues['note'])) . '</td>
        </tr>
        </table>';

        $output = '<html>
     
    <head>
<style>
                @page {
                    font-family: "Courier Prime", monospace !important;
                    margin: 20px 25px;
                    @bottom-right {
                        content: "Página" counter(page) " de " $total_pages; 
                        font-size: 10px;
                    }
                }

                .header {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    border-bottom: 1px thin solid #000;
                    margin-bottom: 30px;
                }

                #logo {
                    width: 100px; 
                    float: left;
                    margin-left: 30px;
                }

                .header .title {
                    font-size: 18px;
                    font-weight: bold;
                }

                #header {
                    padding: 30px 20px 20px;
                    position: relative;
                }

                table {
                    font-size: 14px; /* Reduzindo o tamanho da fonte */
                    border-collapse: collapse;
                    width: 100%;
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                th, td {
                    padding: 3px; /* Reduzindo o padding */
                    border: 1px solid #ddd;
                }

                thead {
                    display: table-header-group;
                }

                tfoot {
                    display: table-footer-group;
                }

                .page-break {
                    page-break-before: always;
                }

                .footer {
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                    text-align: right;
                    font-size: 10px; /* Reduzindo o tamanho da fonte */
                    right: 0px;
                }

               .page-number::after {
                    content: counter(page) ";
                }
            </style>
    </head>
    <body>
        ' . $output . '
    </body>
    </html>';

    $prodFileName = 'AstroProd_' . htmlspecialchars($prodValues['order_id']) . '.pdf';
    require_once 'dompdf/src/Autoloader.php';
    Dompdf\Autoloader::register();
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml(html_entity_decode($output));
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream($prodFileName, array("Attachment" => false));
}
