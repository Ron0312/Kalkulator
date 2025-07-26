document.getElementById("preisrechner-formular").addEventListener("submit", function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch("https://deine-server-url.de/formular-handler.php", {
    method: "POST",
    body: formData
  })
  .then(response => {
    if (!response.ok) throw new Error("Serverfehler");
    return response.text();
  })
  .then(result => {
    document.getElementById("formular-status").classList.remove("hidden");
    form.reset();
  })
  .catch(error => {
    alert("Fehler beim Absenden: " + error.message);
  });
});
