$(document).ready(function () {
  // Seleciona todos os eventos relacionados aos elementos.
  $(document).on("click", "#checkAll", function () {
    $(".itemRow").prop("checked", this.checked);
  });

  $(document).on("click", ".itemRow", function () {
    if ($(".itemRow:checked").length == $(".itemRow").length) {
      $("#checkAll").prop("checked", true);
    } else {
      $("#checkAll").prop("checked", false);
    }
  });

  var count = $(".itemRow").length;

  $(document).on("click", "#addRows", function () {
    count++;
    var htmlRows = "";
    htmlRows += "<tr>";
    htmlRows +=
      '<td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input itemRow" id="itemRow_' +
      count +
      '"><label class="custom-control-label" for="itemRow_' +
      count +
      '"></label></div></td>';
    htmlRows +=
      '<td><input type="text" name="productCode[]" id="productCode_' +
      count +
      '" class="form-control" autocomplete="off"></td>';
    htmlRows +=
      '<td><select class="form-control serviceName serviceName" name="serviceName[]" id="serviceName_' +
      count +
      '"><option value="">Selecione o Tipo de Serviço</option></select></td>';
    htmlRows +=
      '<td><input type="number" name="qtdfiscal[]" id="qtdfiscal_' +
      count +
      '" class="form-control qtdfiscal" autocomplete="off"></td>';
    htmlRows +=
      '<td><input type="number" name="price[]" id="price_' +
      count +
      '" class="form-control price" autocomplete="off"></td>';
    htmlRows +=
      '<td><input type="number" name="total[]" id="total_' +
      count +
      '" class="form-control total" autocomplete="off"></td>';
    htmlRows += "</tr>";
    $("#prodItem").append(htmlRows);

    // Recarregar tipos de serviço na nova linha
    loadServiceTypes("#serviceName_" + count);
  });

  $(document).on("click", "#removeRows", function () {
    $(".itemRow:checked").each(function () {
      $(this).closest("tr").remove();
    });
    $("#checkAll").prop("checked", false);
    calculateTotal();
  });

  $(document).on("blur", "[id^=qtdfiscal_]", function () {
    calculateTotal();
  });

  $(document).on("blur", "[id^=price_]", function () {
    calculateTotal();
  });

  $(document).on("blur", "#taxRate", function () {
    calculateTotal();
  });

  $(document).on("blur", "#amountPaid", function () {
    var amountPaid = $(this).val();
    var totalAftertax = $("#totalAftertax").val();
    if (amountPaid && totalAftertax) {
      totalAftertax = totalAftertax - amountPaid;
      $("#amountDue").val(totalAftertax);
    } else {
      $("#amountDue").val(totalAftertax);
    }
  });

  $(document).on("change", "select[id^='serviceName_']", function () {
    var id = $(this).attr("id").replace("serviceName_", "");
    var selectedService = $(this).val();
    var priceInput = $("#price_" + id);

    // Atualize o preço com base no serviço selecionado (você precisa implementar essa função)
    updatePriceBasedOnService(selectedService, priceInput);

    // Recalcular total
    calculateTotal();
  });

  $(document).on("click", ".deleteProd", function () {
    var id = $(this).attr("id");
    if (confirm("Tem certeza de que deseja remover isso?")) {
      $.ajax({
        url: "action.php",
        method: "POST",
        dataType: "json",
        data: { id: id, action: "delete_prod" },
        success: function (response) {
          if (response.status == 1) {
            $("#" + id)
              .closest("tr")
              .remove();
          }
        },
      });
    } else {
      return false;
    }
  });
});

function calculateTotal() {
  var totalAmount = 0;
  $("[id^='price_']").each(function () {
    var id = $(this).attr("id").replace("price_", "");
    var price = parseFloat($("#price_" + id).val());
    var qtdfiscal = parseFloat($("#qtdfiscal_" + id).val());

    if (!isNaN(price) && !isNaN(qtdfiscal) && qtdfiscal > 0) {
      var total = price * qtdfiscal; // Corrigir para multiplicar preço pela quantidade
      $("#total_" + id).val(total.toFixed(2)); // Define o total com 2 casas decimais
      totalAmount += total; // Adiciona ao total geral
    } else {
      $("#total_" + id).val(""); // Se a quantidade for inválida, o total é limpo
    }
  });
  $("#subTotal").val(totalAmount.toFixed(2)); // Define o subtotal com 2 casas decimais

  // Cálculos de impostos e total após o subtotal...
}

function loadServiceTypes(selectId) {
  // Função fictícia para carregar tipos de serviço no <select>
  // Implemente isso para preencher as opções com base na sua lógica
}

function updatePriceBasedOnService(service, priceInput) {
  // Função fictícia para atualizar o preço com base no serviço selecionado
  // Implemente isso para definir o preço correto para o serviço selecionado
}
