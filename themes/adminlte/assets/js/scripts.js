// JQUERY INIT
$(function () {
  var ajaxResponseBaseTime = 3;
  var ajaxResponseRequestError =
    "<div class='message error icon-warning'>Desculpe mas não foi possível processar sua requisição...</div>";

  //FORMS
  $("form:not('.ajax_off')").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var load = $(".ajax_load");

    if (typeof tinyMCE !== "undefined") {
      tinyMCE.triggerSave();
    }

    form.ajaxSubmit({
      url: form.attr("action"),
      type: "POST",
      dataType: "json",
      beforeSend: function () {
        load.fadeIn(200).css("display", "flex");
      },
      uploadProgress: function (event, position, total, completed) {
        var loaded = completed;
        var load_title = $(".ajax_load_box_title");
        load_title.text("Enviando (" + loaded + "%)");

        if (completed >= 100) {
          load_title.text("Aguarde, carregando...");
        }
      },
      success: function (response) {
        //redirect
        if (response.redirect) {
          window.location.href = response.redirect;
        } else {
          form.find("input[type='file']").val(null);
          load.fadeOut(200);
        }

        //reload
        if (response.reload) {
          window.location.reload();
        } else {
          load.fadeOut(200);
        }

        //message
        if (response.message) {
          ajaxMessage(response.message, ajaxResponseBaseTime);
        }

        //image by fsphp mce upload
        if (response.mce_image) {
          $(".mce_upload").fadeOut(200);
          tinyMCE.activeEditor.insertContent(response.mce_image);
        }
      },
      complete: function () {
        if (form.data("reset") === true) {
          form.trigger("reset");
        }
      },
      error: function () {
        ajaxMessage(ajaxResponseRequestError, 5);
        load.fadeOut();
      },
    });
  });

  // AJAX RESPONSE

  function ajaxMessage(message, time) {
    var ajaxMessage = $(message);

    ajaxMessage.append("<div class='message_time'></div>");
    ajaxMessage
      .find(".message_time")
      .animate({ width: "100%" }, time * 1000, function () {
        $(this).parents(".message").fadeOut(200);
      });

    $(".ajax_response").append(ajaxMessage);
    ajaxMessage.effect("bounce");
  }

  // AJAX RESPONSE MONITOR

  $(".ajax_response .message").each(function (e, m) {
    ajaxMessage(m, (ajaxResponseBaseTime += 1));
  });

  // AJAX MESSAGE CLOSE ON CLICK

  $(".ajax_response").on("click", ".message", function (e) {
    $(this).effect("bounce").fadeOut(1);
  });

  // MAKS

  $(".mask-date").mask("00/00/0000");
  $(".mask-datetime").mask("00/00/0000 00:00");
  $(".mask-month").mask("00/0000", { reverse: true });
  $(".mask-doc").mask("000.000.000-00", { reverse: true });
  $(".mask-card").mask("0000  0000  0000  0000", { reverse: true });
  $(".mask-money").mask("000.000.000.000.000,00", {
    reverse: true,
    placeholder: "0,00",
  });
  $(".mask-phone").mask("(00) 0 0000-0000", {
    placeholder: "(99) 9 9999-9999",
  });

  $(".select2").select2();
  $("#pieces").select2({
    tags: true,
  });

  $("[data-post]").click(function (e) {
    e.preventDefault();

    var clicked = $(this);
    var data = clicked.data();
    var load = $(".ajax_load");

    if (data.confirm) {
      var deleteConfirm = confirm(data.confirm);
      if (!deleteConfirm) {
        return;
      }
    }

    $.ajax({
      url: data.post,
      type: "POST",
      data: data,
      dataType: "json",
      beforeSend: function () {
        load.fadeIn(200).css("display", "flex");
      },
      success: function (response) {
        //redirect
        if (response.redirect) {
          window.location.href = response.redirect;
        } else {
          load.fadeOut(200);
        }

        //reload
        if (response.reload) {
          window.location.reload();
        } else {
          load.fadeOut(200);
        }

        //message
        if (response.message) {
          ajaxMessage(response.message, ajaxResponseBaseTime);
        }
      },
      error: function () {
        ajaxMessage(ajaxResponseRequestError, 5);
        load.fadeOut();
      },
    });
  });

  // Selecione os elementos onde você quer aplicar a regra (ajuste o seletor conforme necessário)
  $(".texto-adaptavel").each(function () {
    var elemento = $(this);
    var bgColor = elemento.css("background-color");

    // Função para calcular a luminosidade (simplificada)
    function getLuminance(hex) {
      // Remover o '#' e converter para um número decimal
      var rgb = parseInt(hex.replace("#", ""), 16);
      var r = (rgb >> 16) & 0xff;
      var g = (rgb >> 8) & 0xff;
      var b = rgb & 0xff;

      // Fórmula de luminosidade aproximada
      return r * 0.299 + g * 0.587 + b * 0.114;
    }

    // Obter a luminosidade do fundo
    var luminance = getLuminance(bgColor);

    // Aplicar a cor do texto
    if (luminance > 150) {
      // Ajuste o valor limite conforme necessário
      elemento.css("color", "black");
    } else {
      elemento.css("color", "white");
    }
  });

  $("[data-postbtn]").click(function (e) {
    e.preventDefault();

    var clicked = $(this);
    var data = clicked.data();
    var load = $(".ajax_load");

    if (data.confirm) {
      var deleteConfirm = confirm(data.confirm);
      if (!deleteConfirm) {
        return;
      }
    }

    $.ajax({
      url: data.postbtn,
      type: "POST",
      data: data,
      dataType: "json",
      beforeSend: function () {
        load.fadeIn(200).css("display", "flex");
      },
      success: function (response) {
        if (response.renewal) {
          clicked.replaceWith("Informação atualizada");
        }

        //redirect
        if (response.redirect) {
          window.location.href = response.redirect;
        } else {
          load.fadeOut(200);
        }

        //reload
        if (response.reload) {
          window.location.reload();
        } else {
          load.fadeOut(200);
        }
      },
      error: function () {
        load.fadeOut();
      },
    });
  });

  $("[data-dojo]").change(function (e) {
    e.preventDefault();

    var clicked = $(this);
    var data = clicked.data();
    var load = $(".ajax_load");

    $.ajax({
      url: data.dojo,
      type: "POST",
      data: { valor: $(this).val() },
      dataType: "json",
      beforeSend: function () {
        load.fadeIn(200).css("display", "flex");
      },
      success: function (data) {
        $("#dojo").empty();
        $.each(data, function (index, item) {
          $("#dojo").append(
            $("<option>", {
              value: item.id,
              text: item.nome,
            })
          );
        });
        load.fadeOut();
      },
      error: function () {
        load.fadeOut();
      },
    });
  });

  $("#example1")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
      language: {
        search: "Pequisar",
        searchPlaceholder: "Digite a sua pesquisa aqui...",
        zeroRecords: "Nenhum registro correspondente encontrado",
        emptyTable: "Não há dados disponíveis na tabela",
        info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        infoEmpty: "Mostrando 0 a 0 de 0 entradas",
        infoFiltered: "(filtrado do total de _MAX_ entradas)",
        loadingRecords: "Carregando...",
        buttons: {
          copy: "Copiar",
          copyTitle: "Dados copiados",
          copySuccess: {
            _: "%d linhas copiadas",
            1: "1 linha copiada",
          },
          copyKeys:
            "Pressione Ctrl+C para copiar os dados para a área de transferência",
          csv: "CSV",
          excel: "Excel",
          pdf: "PDF",
          print: "Imprimir",
          colvis: "Colunas",
        },
        paginate: {
          first: "Primeiro",
          last: "Último",
          next: "Próximo",
          previous: "Anterior",
        },
        aria: {
          orderable: "Ordenar por esta coluna",
          orderableReverse: "Ordem inversa desta coluna",
        },
      },
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");

  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  // Função para ler cookies
  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == " ") c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

  $('.card-tools button[data-card-widget="collapse"]').click(function () {
    var url = $(this).data("url");
    var card = $(this).closest(".card");
    var cardBody = card.find(".card-body");
    var cardId = card.data("card-id");
    var isCollapsed = card.hasClass("collapsed-card");

    setCookie("card_state_" + cardId, isCollapsed, 7);
  });

  $("#example2")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      searching: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
      language: {
        search: "Pequisar",
        searchPlaceholder: "Digite a sua pesquisa aqui...",
        zeroRecords: "Nenhum registro correspondente encontrado",
        emptyTable: "Não há dados disponíveis na tabela",
        info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        infoEmpty: "Mostrando 0 a 0 de 0 entradas",
        infoFiltered: "(filtrado do total de _MAX_ entradas)",
        loadingRecords: "Carregando...",
        buttons: {
          copy: "Copiar",
          copyTitle: "Dados copiados",
          copySuccess: {
            _: "%d linhas copiadas",
            1: "1 linha copiada",
          },
          copyKeys:
            "Pressione Ctrl+C para copiar os dados para a área de transferência",
          csv: "CSV",
          excel: "Excel",
          pdf: "PDF",
          print: "Imprimir",
          colvis: "Colunas",
        },
        paginate: {
          first: "Primeiro",
          last: "Último",
          next: "Próximo",
          previous: "Anterior",
        },
        aria: {
          orderable: "Ordenar por esta coluna",
          orderableReverse: "Ordem inversa desta coluna",
        },
      },
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");
});

function getPassword() {
  var chars =
    "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ!@#$%^&*()+?><:{}[]";
  var passwordLength = 16;
  var password = "";

  for (var i = 0; i < passwordLength; i++) {
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber + 1);
  }
  document.getElementById("password").value = password;
}

const addressForm = document.querySelector("#address-form");
const cepInput = document.querySelector("#cep");
const addressInput = document.querySelector("#address");
const cityInput = document.querySelector("#city");
const neighborhoodInput = document.querySelector("#neighborhood");
const regionInput = document.querySelector("#state");
const formInputs = document.querySelectorAll("[data-input]");

// Validate CEP Input
cepInput.addEventListener("keypress", (e) => {
  const onlyNumbers = /[0-9]|\./;
  const key = String.fromCharCode(e.keyCode);

  // allow only numbers
  if (!onlyNumbers.test(key)) {
    e.preventDefault();
    return;
  }
});

// Evento to get address
cepInput.addEventListener("keyup", (e) => {
  const inputValue = e.target.value;

  //   Check if we have a CEP
  if (inputValue.length === 8) {
    getAddress(inputValue);
  }
});

// Get address from API
const getAddress = async (cep) => {
  toggleLoader();

  cepInput.blur();

  const apiUrl = `https://viacep.com.br/ws/${cep}/json/`;

  const response = await fetch(apiUrl);

  const data = await response.json();

  // Show error and reset form
  if (data.erro === "true") {
    if (!addressInput.hasAttribute("disabled")) {
      toggleDisabled();
    }

    addressForm.reset();
    toggleLoader();
    alert("CEP Inválido, tente novamente.");
    return;
  }

  // Activate disabled attribute if form is empty
  if (addressInput.value === "") {
    toggleDisabled();
  }

  addressInput.value = data.logradouro;
  cityInput.value = data.localidade;
  neighborhoodInput.value = data.bairro;
  regionInput.value = data.uf;

  toggleLoader();
};

// Add or remove disable attribute
const toggleDisabled = () => {
  if (regionInput.hasAttribute("disabled")) {
    formInputs.forEach((input) => {
      input.removeAttribute("disabled");
    });
  } else {
    formInputs.forEach((input) => {
      input.setAttribute("disabled", "disabled");
    });
  }
};

// Show or hide loader
const toggleLoader = () => {
  const loaderElement = document.querySelector(".ajax_load");
  loaderElement.classList.toggle("hide");
};

// Show or hide message
const toggleMessage = (msg) => {
  const fadeElement = document.querySelector("#fade");
  const messageElement = document.querySelector("#message");

  const messageTextElement = document.querySelector("#message p");

  messageTextElement.innerText = msg;

  fadeElement.classList.toggle("hide");
  messageElement.classList.toggle("hide");
};
