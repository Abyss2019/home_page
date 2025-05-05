let targetDOI = "";

function showForm(doiURL) {
  targetDOI = doiURL;
  document.getElementById("popup").style.display = "block";
}

function submitForm() {
  const email = document.getElementById("email").value.trim();
  const affiliation = document.getElementById("affiliation").value.trim();

  console.log(">>> submitForm()", { email, affiliation });  // 调试：是否进来

  if (!email || !affiliation) {
    alert("Please fill in both fields or click Skip.");
    return;
  }

  if (!validateEmail(email)) {
    alert("Please enter a valid email address.");
    return;
  }

  const url = "../api/save_form.php";
  console.log(">>> fetch URL:", url);  // 调试：请求地址

  fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, affiliation })
  })
  .then(res => {
    console.log(">>> HTTP status:", res.status);  // 调试：状态码
    return res.json();
  })
  .then(data => {
    console.log(">>> response JSON:", data);  // 调试：返回内容
    if (data.status === "success") {
      window.open(targetDOI, "_blank");
      closeForm();
    } else {
      alert("Failed to save form: " + data.message);
    }
  })
  .catch(err => {
    console.error(">>> fetch error:", err);  // 调试：错误信息
    alert("Submission error. Please try again.");
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