const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', ()=> {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-popup');
});

function toggleButtons() {
    var button1 = document.getElementById("button1");
    var button2 = document.getElementById("button2");
    var icon1 = document.getElementById("icon1");
    var icon2 = document.getElementById("icon2");
    if (button1.style.display === "" || button1.style.display === "inline-block") {
      button1.style.display = "none";
      button2.style.display = "inline-block";
      icon1.classList.remove("like");
      icon1.classList.add("unLike");
      icon2.classList.remove("unLike");
      icon2.classList.add("like");
    } else {
      button1.style.display = "inline-block";
      button2.style.display = "none";
      icon1.classList.remove("unLike");
      icon1.classList.add("like");
      icon2.classList.remove("like");
      icon2.classList.add("unLike");
    }
}
  