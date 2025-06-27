let targetDOI = "";

function showForm(doiURL) {
  targetDOI = doiURL;
  document.getElementById("popup").style.display = "block";
}

function submitForm() {
  const email = document.getElementById("email").value.trim();
  const affiliation = document.getElementById("affiliation").value.trim();

  if (!email || !affiliation) {
    alert("Please fill in both fields or click Skip.");
    return;
  }

  localStorage.setItem("vrocklab_email", email);
  localStorage.setItem("vrocklab_affiliation", affiliation);

  window.open(targetDOI, "_blank");
  closeForm();
}

function skipForm() {
  window.open(targetDOI, "_blank");
  closeForm();
}

function closeForm() {
  document.getElementById("popup").style.display = "none";
}
