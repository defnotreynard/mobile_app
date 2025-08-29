
function submitReport() {
  let formData = new FormData();

  // Collect form fields
  formData.append("address", document.querySelector("input[name=address]").value);
  formData.append("pole_condition", document.querySelector("input[name=pole_condition]:checked")?.value || "");
  formData.append("notes", document.querySelector("textarea[name=notes]").value);
  formData.append("severity", document.querySelector("input[name=severity]:checked")?.value || "");

  // Hazards (multiple checkboxes or chips)
  let hazards = Array.from(document.querySelectorAll("input[name='hazards[]']:checked")).map(el => el.value);
  hazards.forEach(h => formData.append("hazards[]", h));

  // Photo upload
  let photoInput = document.querySelector("input[name=photo]");
  if (photoInput && photoInput.files.length > 0) {
    formData.append("photo", photoInput.files[0]);
  }

  // Send AJAX to PHP
  fetch("insert_report.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    alert(data); // Show success or error from PHP
  })
  .catch(err => {
    alert("❌ Error submitting report: " + err);
  });
}

