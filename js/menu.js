let barranav = document.querySelector('.cabecalho .barranav');

document.querySelector('#menu-botao').onclick = () => {
    barranav.classList.toggle('active');
}

window.onscroll = () => {
    barranav.classList.remove('active');
}