document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('preisrechner-form');
  const responseBox = document.getElementById('response');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('action', 'send_calculator_email'); // WP-Hook

    try {
      const response = await fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.success) {
        responseBox.textContent = '✅ Anfrage erfolgreich gesendet.';
        form.reset();
      } else {
        responseBox.textContent = '⚠️ Fehler: ' + (result.message || 'Unbekannter Fehler.');
      }
    } catch (err) {
      console.error(err);
      responseBox.textContent = '❌ Technischer Fehler beim Senden.';
    }
  });
});
