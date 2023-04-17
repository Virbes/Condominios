// JavaScript Document
var imgload2 =
  '<div class="container-load-spinner"><span class="spinner"></span></div>';
var imgload3 =
  '<div class="offset-1 container-normal-spinner "><span class="spinner"></span></div>';
var spinner_load =
  '<div class="mx-auto my-auto d-flex" style="justify-content: center;height: 50vh;align-items: center;"><div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden"></span></div></div>';
var load_button =
  '<span class="icon text-white-50 py-1"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></span><span class="text">Cargando...</span>';
var validacion = false;

$(document).ready(function () {
  $(document).on("click", "img", function () {
    if (!$(this).attr("class")) {
      $("img").magnificPopup({ type: "image" });
      $(this).click();
    }
  });

  var modalerror = $("#errorModal").html();
  var pathfile = "/home/files";
  var pathfileapi = "/api/ajax/repositorio";

  $(document).on("click", ".Menu1", function () {
    var IDMenu = $(this).attr("name");
    form_action(pathfile, IDMenu);
  });

  /** modales */
  $(document).on("click", ".AbreModal", function () {
    var obj = this;
    var ok_button = $(obj).html();
    var formData = new FormData();
    formData.append("IDPOST", $(this).attr("id"));
    formData.append("IDPOST2", $(this).attr("media"));
    formData.append("nrel", $(this).attr("rel"));
    formData.append("npopup", $(this).attr("title"));
    formData.append("nname", $(this).attr("name"));
    formData.append("MODPOST", $(this).attr("dir"));
    formData.append("nrev", $(this).attr("rev"));
    var fileload = $(this).attr("name");
    $.ajax({
      url: pathfileapi + fileload,
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function () {
        $(obj).html(load_button).prop("disabled", true);
        $("#staticBackdrop").html(load_button);
      },

      success: function (data) {
        $(obj).html(ok_button).prop("disabled", false);
        $("#staticBackdrop").html(data);
      },

      error: function (data) {
        $("#staticBackdrop").html(modalerror);
      },
    });
  });

  /**Inicion de las funciones de guardado modal */
  $(document).on("submit", "#form_save", function () {
    var obj = this;
    var ok_button = $("#btn_form", obj).html();
    var form_file = $("#form_file", obj).val();
    var form_redirect = $("#form_redirect", obj).val();
    var MODPOST2 = $("#MODPOST2", obj).val();
    var ID = $("#IDPOST", obj).val();
    var formData = new FormData($(obj)[0]);

    $.ajax({
      url: pathfileapi + form_file,
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function () {
        $("#btn_form", obj).html(load_button).prop({ disabled: true });
      },

      success: function (data) {
        validacion = false;
        $("#btn_form", obj).html(ok_button).prop("disabled", data.r_.Val);
        $("#btn_form", obj).html(
          '<span class="icon text-white-50">' +
            '<i class="' +
            data.r_.Icon +
            '"></i></span>' +
            '<span class="text">' +
            data.r_.OutVal +
            "</span>"
        );
        if (data.r_.html) {
          $(obj).append(data.r_.html);
        }

        if (!data.r_.no_redirect) {
          if (data.r_.redirect) {
            //    form_redirect = data.r_.redirect;
            form_action(pathfile, form_redirect);
          } else {
            var table = $("#dataTable").DataTable();
            table.search($("[type=search]").val()).draw();
          }
        }
        if (data.r_.Val) {
          $("#staticBackdrop").modal("hide");
        }
      },
      error: function (data) {
        $("#modal").html(modalerror);
        console.log(data);
      },
    });

    return false;
  });

  $(document).on("click", "#btn_upfile", function () {
    var formData = new FormData($("#form_save")[0]);
    var fileload = $("#form_file").val();

    $.ajax({
      url: pathfileapi + fileload,
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function () {
        $("#response_carga").html(imgload3);
      },

      success: function (data) {
        $("#response_carga").html(data);
      },

      error: function (data) {
        $("#modal").html(modalerror);
      },
    });
  });

  window.setInterval(function () {
    cron_notify("#cron-mensajes", "header_mjs", "mensaje");
    cron_notify("#cron-alertas", "header_alertas", "alerta");
  }, 10000);
});

function cron_notify(id, mod, file) {
  var formData = new FormData();
  formData.append("MODPOST", mod);
  $.ajax({
    url: "/api/ajax/repositorio/" + file + "/",
    type: "POST",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,

    beforeSend: function () {},

    success: function (response) {
      if (response.r_.html) {
        $(id).html(response.r_.html);
      } else {
        $(id).html(response.r_.OutVal);
      }
    },
    error: function (data) {
      $(id).html("Error al sincronizar");
    },
  });
}

function validar(obj, width, height) {
  var foto = obj.files[0];

  if (obj.files.length == 0 || !/\.(jpg|jpeg|png)$/i.test(foto.name)) {
    alert(
      "Ingrese una imagen con alguno de los siguientes formatos: .jpeg/.jpg."
    );
    $(obj).val("");
  }

  var img = new Image();
  img.onload = function () {
    if (this.width.toFixed(0) != 800 && this.height.toFixed(0) != 800) {
      alert(
        "La imagen debe ser de tamaño " + width + "px por " + height + "px."
      );
      $(obj).val("");
    }
  };
  img.src = URL.createObjectURL(foto);
}

function form_action(pathfile, form_redirect) {
  $("#divbody").html(spinner_load);
  $("#divbody").load(
    pathfile + "/" + (form_redirect ? form_redirect : "404.php")
  );
}
