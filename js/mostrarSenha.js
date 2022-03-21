mostrar_senha = () => {
    let senha = window.document.getElementById('password');
    if(senha.type == 'password'){
        senha.type = 'text';
    }else{
        senha.type = 'password';
    }
}