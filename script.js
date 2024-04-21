document.addEventListener('DOMContentLoaded', (event) => {
    const nomeInput = document.getElementById('nome-glow'); 
    const allPersonalInputs = [
        nomeInput, 
        document.getElementById('cpf'), 
        document.getElementById('email'), 
        document.getElementById('telefone'), 
        document.getElementById('data_nascimento')
    ];

    const allFinancialElements = [
        document.getElementById('valor_compra'), 
        document.getElementById('taxa_juros'), 
        document.getElementById('num_parcelas'), 
        document.getElementById('valor_entrada'), 
        document.querySelector('button[type="submit"]')
    ];

    const financialDetailsDiv = document.getElementById('financial-details');

    // Função para ativar/desativar elementos financeiros
    function toggleFinancialFields() {
        let allFilled = allPersonalInputs.every(input => input.value.trim() !== '');
        allFinancialElements.forEach(el => el.disabled = !allFilled);

        if (!allFilled) {
            financialDetailsDiv.classList.add('disabled-div');
        } else {
            financialDetailsDiv.classList.remove('disabled-div');
        }
    }

    // Função para ajustar o efeito glow
    function adjustGlowEffect() {
        if (nomeInput.value.trim()) {
            nomeInput.classList.remove('glow-effect');
        } else {
            nomeInput.classList.add('glow-effect');
        }
    }

    // Aplica a verificação do efeito de glow no carregamento da página
    adjustGlowEffect();

    // Evento para ajustar o efeito de glow durante a digitação no campo "Nome"
    nomeInput.addEventListener('input', adjustGlowEffect);

    // Adiciona evento de input para todos os campos de Dados Pessoais
    // Ativar/desativar campos financeiros
    allPersonalInputs.forEach(input => {
        input.addEventListener('input', toggleFinancialFields);
    });

    // Verifica inicialmente se os campos financeiros devem ser ativados/desativados
    toggleFinancialFields();
});
