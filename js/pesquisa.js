filtrar = () => {
    var input = document.getElementById('pesquisa');
    var filtro = input.value.toUpperCase();
    var menu = document.getElementById('menu');
    var itens = menu.getElementsByTagName('li');
    for(var i = 0; i < itens.length; i++){
        var links = itens[i].getElementsByTagName('span')[0];
        if(links.innerHTML.toUpperCase().indexOf(filtro) > -1){
            itens[i].style.display='';
        }else{
            itens[i].style.display='none';
        }
    }
}