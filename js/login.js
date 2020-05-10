function signUpFun() {
  var container = document.getElementById("container");
  console.log(container);
  container.classList.add("right-panel-active");
}

function signInFun() {
  var container = document.getElementById("container");
  container.classList.remove("right-panel-active");
}
