$(function () {

    const urlBase = "index.php";

    function cargarTalleres() {
        $.ajax({
            url: urlBase + "?option=talleres_json",
            method: "GET",
            dataType: "json",
            success: function (data) {

                let tbody = $("#talleres-body");
                tbody.html("");

                if (!data || data.length === 0) {
                    tbody.append("<tr><td colspan='5'>No hay talleres</td></tr>");
                    return;
                }

                data.forEach(function(taller) {

                    let disabled = taller.cupo_disponible <= 0;
                    let clase = disabled ? "btn-secondary" : "btn-success";
                    let texto = disabled ? "Sin cupo" : "Solicitar";

                    tbody.append(`
                        <tr class="${disabled ? 'text-muted' : ''}">
                            <td>${taller.id}</td>
                            <td>${taller.nombre}</td>
                            <td>${taller.descripcion}</td>
                            <td>${taller.cupo_disponible}</td>
                            <td>
                                <button 
                                    class="btn ${clase} btn-solicitar" 
                                    data-id="${taller.id}"
                                    ${disabled ? "disabled" : ""}
                                >
                                    ${texto}
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    $(document).on("click", ".btn-solicitar", function () {
        let tallerId = $(this).data("id");

        $.ajax({
            url: urlBase,
            method: "POST",
            data: {
                option: "solicitar",
                taller_id: tallerId
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Solicitud enviada");
                    cargarTalleres(); // refresca cupos
                } else {
                    alert(response.error);
                }
            }
        });
    });

    cargarTalleres();
});