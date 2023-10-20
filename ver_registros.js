document.addEventListener("DOMContentLoaded", function () {
    var verRegistrosButton = document.getElementById("verRegistros");
    var registrosList = document.getElementById("registrosList");

    verRegistrosButton.addEventListener("click", function () {
        // Realiza la solicitud GET para obtener los registros
        fetch("ver_registros.php")
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error en la solicitud al servidor");
                }
            })
            .then(function (data) {
                // Limpia la lista de registros
                registrosList.innerHTML = "";

                // Agrega los registros a la lista
                data.forEach(function (registro) {
                    var listItem = document.createElement("li");
                    listItem.textContent = `Fecha: ${registro.fecha}, Hora: ${registro.hora}, Cantidad: ${registro.cantidad}, Zona: ${registro.zona}`;
                    registrosList.appendChild(listItem);
                });
            })
            .catch(function (error) {
                alert(error.message);
            });
    });
});
