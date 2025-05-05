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

  if (!validateEmail(email)) {
    alert("Please enter a valid email address.");
    return;
  }

  // ✅ 向 save_form.php 发送数据
  fetch('api/save_form.php', {
    method: 'POST',
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, affiliation })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      window.open(targetDOI, "_blank");
      closeForm();
    } else {
      alert("Failed to save form: " + data.message);
    }
  })
  .catch(err => {
    alert("Submission error. Please try again.");
    console.error(err);
  });
}


function skipForm() {
  window.open(targetDOI, "_blank");
  closeForm();
}

function closeForm() {
  document.getElementById("popup").style.display = "none";
}

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}