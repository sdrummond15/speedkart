jQuery(document).ready(function ($) {
  var url = window.location.pathname;
  var pathname = window.location.pathname.indexOf("index.php");
  var path = "";
  if (pathname >= 0) {
    path = url.substr("0", pathname);
  } else {
    path = "";
  }

  $("#msg-box .fechar").on("click", function () {
    $("#msg-box").slideUp();
  });
  
  $("#telefone").mask("(00) 00000-0000");
  $("#dtniver").mask("00/00/0000");
  

  $("#dtniver").on("focusout", function() {
    if(isValidDate($(this).val())){
      alert('Data de Nascimento inválida!')
      $(this).val('')
    }
  });

  function isValidDate(txtDate) {
    var currVal = txtDate;
    if (currVal == "") {
      return false;
    }

    //Declare Regex
    var rxDatePattern = "/^(d{1,2})(/|-)(d{1,2})(/|-)(d{4})$/";
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null) {
      return false;
    }

    //Checks for dd/mm/yyyy format.
    dtDay = dtArray[1];
    dtMonth = dtArray[3];
    dtYear = dtArray[5];

    if (dtMonth < 1 || dtMonth > 12) {
      return false;
    } else if (dtDay < 1 || dtDay > 31) {
      return false;
    } else if (
      (dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) &&
      dtDay == 31
    ) {
      return false;
    } else if (dtMonth == 2) {
      var isleap = dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0);
      if (dtDay > 29 || (dtDay == 29 && !isleap)) {
        return false;
      }
    }
    return true;
  }

  $("div.enviado > div.fechar i").click(function () {
    $(".enviado-overlay").css("transition", "linear 100ms");
    $(".enviado-overlay").hide();
    $(".enviado").css("transition", "linear 100ms");
    $(".enviado").hide();
    window.location.replace(baseUrl);
  });

  $(document).keyup(function (e) {
    if (e.keyCode == 27) {
      $(".enviado-overlay").css("transition", "linear 100ms");
      $(".enviado-overlay").hide();
      $(".enviado").css("transition", "linear 100ms");
      $(".enviado").hide();
      window.location.replace(baseUrl);
    }
  });

  $(".enviado-overlay").click(function () {
    $(".enviado-overlay").css("transition", "linear 100ms");
    $(".enviado-overlay").hide();
    $(".enviado").css("transition", "linear 100ms");
    $(".enviado").hide();
    window.location.replace(baseUrl);
  });

  $("#form-subscribe").submit(function(){
    $('.loading').show()
  });

});
