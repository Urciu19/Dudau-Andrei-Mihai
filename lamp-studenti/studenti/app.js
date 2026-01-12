const API = "api/plozi.php";
const tabel = document.getElementById("catalog");
const form = document.getElementById("formStudent");

/* Afișare catalog (GET) */
async function incarcaCatalog() {
    const res = await fetch(API);
    const studenti = await res.json();

    tabel.innerHTML = "";

    studenti.forEach(s => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${s.nume}</td>
            <td>${s.an}</td>
            <td>${s.media}</td>
        `;
        tabel.appendChild(tr);
    });
}

/* Adăugare student (POST) */
form.addEventListener("submit", async e => {
    e.preventDefault();

    await fetch(API, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            nume: document.getElementById("nume").value,
            an: document.getElementById("an").value,
            media: document.getElementById("media").value
        })
    });

    form.reset();
    incarcaCatalog(); // actualizare în timp real
});

/* Afișare inițială */
incarcaCatalog();
