document.addEventListener('DOMContentLoaded', function () {
    const formServico = document.querySelector('form[data-validar="servico"]');

    if (formServico) {
        formServico.addEventListener('submit', function (evento) {
            const descricao = formServico.querySelector('[name="descricao"]');
            const valor = formServico.querySelector('[name="valor"]');
            let mensagemErro = '';

            if (descricao.value.trim() === '') {
                mensagemErro = 'Preencha a descrição do serviço.';
            } else if (valor.value === '' || isNaN(valor.value) || parseFloat(valor.value) <= 0) {
                mensagemErro = 'Informe um valor válido, maior que zero.';
            }

            if (mensagemErro !== '') {
                evento.preventDefault();
                mostrarErro(formServico, mensagemErro);
            }
        });
    }

    document.querySelectorAll('a[data-confirmar]').forEach(function (link) {
        link.addEventListener('click', function (evento) {
            const mensagem = link.getAttribute('data-confirmar');
            if (!confirm(mensagem)) {
                evento.preventDefault();
            }
        });
    });
});

function mostrarErro(form, mensagem) {
    let erro = form.querySelector('.erro-validacao');
    if (!erro) {
        erro = document.createElement('p');
        erro.className = 'erro-validacao';
        erro.style.color = 'red';
        form.prepend(erro);
    }
    erro.textContent = mensagem;
}