document.getElementById("kontaktformular").addEventListener("submit", async function(e) {
    e.preventDefault();
    const form = e.target;
    const responseBox = document.getElementById("response");

    const formData = new FormData(form);

    if (formData.get("website")) {
        return;
    }

    const response = await fetch(form.action, {
        method: "POST",
        body: formData
    });

    const result = await response.text();
    responseBox.textContent = result;
    responseBox.classList.remove("hidden");
    form.reset();
});