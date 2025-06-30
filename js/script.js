document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Evita recargar la página

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMessage = document.getElementById("error-message");

  if (username === "" || password === "") {
    errorMessage.textContent = "Por favor, completa todos los campos.";
    return;
  }

  if (username === "admin" && password === "1234") {
    alert("¡Inicio de sesión exitoso!");
    errorMessage.textContent = "";
    // Aquí puedes redireccionar a otra página
    // window.location.href = "pagina_principal.html";
  } else {
    errorMessage.textContent = "Usuario o contraseña incorrectos.";
  }
});
