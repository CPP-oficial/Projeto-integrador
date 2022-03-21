let botao = window.document.querySelector('#botao');
let barra_lateral = window.document.querySelector('.barra_lateral');
let botao_pesquisa = window.document.querySelector('.fa-search');

botao.onclick = () => {
    barra_lateral.classList.toggle('active');
}

botao_pesquisa.onclick = () => {
    barra_lateral.classList.toggle('active');
}