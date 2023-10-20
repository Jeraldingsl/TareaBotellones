document.addEventListener("DOMContentLoaded", function () {
    var registroForm = document.getElementById("registroForm");
    var fechaInput = document.getElementById("fecha");
    var horaInput = document.getElementById("hora");
    var cantidadInput = document.getElementById("cantidad");
    var zonaInput = document.getElementById("zona");

    registroForm.addEventListener("submit", function (event) {
        event.preventDefault();

        var fecha = fechaInput.value;
        var hora = horaInput.value;
        var cantidad = cantidadInput.value;
        var zona = zonaInput.value;

        var formData = new FormData();
        formData.append("fecha", fecha);
        formData.append("hora", hora);
        formData.append("cantidad", cantidad);
        formData.append("zona", zona);

        fetch("server.php", {
            method: "POST",
            body: formData,
        })
            .then(function (response) {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error("Error en la solicitud al servidor");
                }
            })
            .then(function (data) {
                alert(data);
                fechaInput.value = "";
                horaInput.value = "";
                cantidadInput.value = "";
                zonaInput.value = "";
            })
            .catch(function (error) {
                alert(error.message);
            });
    });

    var generarPDFButton = document.getElementById("generarPDF");
    var pdfContainer = document.getElementById("pdfContainer");

    generarPDFButton.addEventListener("click", function () {
        // Realiza una solicitud al servidor para generar el PDF
        fetch("generar_pdf.php")
            .then(function (response) {
                if (response.ok) {
                    return response.blob();
                } else {
                    throw new Error("Error al generar el PDF");
                }
            })
            .then(function (blob) {
                // Crea una URL para el blob del PDF
                var pdfUrl = URL.createObjectURL(blob);

                // Crea un elemento iframe para mostrar el PDF
                var pdfIframe = document.createElement("iframe");
                pdfIframe.src = pdfUrl;
                pdfIframe.style.width = "100%";
                pdfIframe.style.height = "500px"; // Ajusta el alto según tus necesidades

                // Limpia el contenedor antes de mostrar el PDF
                pdfContainer.innerHTML = "";

                // Agrega el elemento iframe al contenedor
                pdfContainer.appendChild(pdfIframe);
            })
            .catch(function (error) {
                alert(error.message);
            });
    });
});

