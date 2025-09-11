let userField = document.getElementById("user_field");
let userPassword = document.getElementById("user_password");

function formSubmit() {
  if (
    userField.value === "user" &&
    userPassword.value === "pass"
  ) {
    userField.classList.remove("user_pass_fail");
    userPassword.classList.remove("user_pass_fail");
    alert("Login realizado com sucesso!");
  } else if (
    userField.value === "" ||
    userPassword.value === ""
  ) {
    userField.classList.add("user_pass_fail");
    userPassword.classList.add("user_pass_fail");
    alert("Por favor, preencha todos os campos.");
    event.preventDefault();
  } else if (
    userPassword !== "pass" ||
    userField !== "user"
  ) {
    userField.classList.add("user_pass_fail");
    userPassword.classList.add("user_pass_fail");
    alert("Usuário ou senha incorretos.");
    event.preventDefault();
  }
};
