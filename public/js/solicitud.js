$(function () {

    const urlBase = "index.php";

    function cargarSolicitudes() {
        fetch(urlBase + "?option=solicitudes_json")
            .then(res => res.json())
            .then(data => {

                console.log("DATA:", data); // 🔥 DEBUG REAL

                let tbody = document.getElementById("solicitudes-body");
                tbody.innerHTML = "";

                if (!data || data.length === 0) {
                    tbody.innerHTML = "<tr><td colspan='5'>No hay solicitudes</td></tr>";
                    return;
                }

                data.forEach(s => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${s.id}</td>
                            <td>${s.taller}</td>
                            <td>${s.usuario}</td>
                            <td>${s.fecha_solicitud}</td>
                            <td>
                                <button class="btn-aprobar" data-id="${s.id}">Aprobar</button>
                                <button class="btn-rechazar" data-id="${s.id}">Rechazar</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(err => console.error("ERROR:", err));
    }

    document.addEventListener("click", function (e) {

        if (e.target.classList.contains("btn-aprobar")) {

            let id = e.target.dataset.id;

            fetch(urlBase, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `option=aprobar&id_solicitud=${id}`
            })
            .then(res => res.json())
            .then(() => {
                cargarSolicitudes(); // 🔥 refresca SIEMPRE
            });
        }

        if (e.target.classList.contains("btn-rechazar")) {

            let id = e.target.dataset.id;

            fetch(urlBase, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `option=rechazar&id_solicitud=${id}`
            })
            .then(res => res.json())
            .then(() => {
                cargarSolicitudes();
            });
        }
    });

    cargarSolicitudes();
});