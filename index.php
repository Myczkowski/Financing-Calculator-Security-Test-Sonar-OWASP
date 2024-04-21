<?php
session_start();

// Verifica se o botão de limpar foi acionado e limpa a sessão
if (isset($_POST['limpar'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Definindo valores iniciais para os campos com valores vazios ou os últimos dados submetidos
$nomeValue = $_SESSION['dados_pessoais']['nome'] ?? '';
$cpfValue = $_SESSION['dados_pessoais']['cpf'] ?? '';
$emailValue = $_SESSION['dados_pessoais']['email'] ?? '';
$telefoneValue = $_SESSION['dados_pessoais']['telefone'] ?? '';
$nascimentoValue = $_SESSION['dados_pessoais']['data_nascimento'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fave icon -->
    <link rel="shortcut icon" href="css/bootstrap-icons-1.11.3/bank.svg" type="image/x-icon">
    <!-- Bootstrap Local -->
    <link href="css/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons Local -->
    <link rel="stylesheet" href="css/bootstrap-icons-1.11.3">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="styles.css">
    <title>Simulação de Financiamento</title>
</head>
<body>
    <header class="site-header">
        <div class="logo-container">
            <img src="css/bootstrap-icons-1.11.3/bank.svg" alt="Logotipo" class="site-logo">
        </div>
        <h1 class="site-title">FINANCIAL DESK</h1>
    </header>

    <nav id="navbar" class="container"></nav>
    
    <!-- Formulário -->
    <div class="container" id="gallery-container">
        <div style='border-bottom: 1px solid black;'></div>
        <form action="simular.php" method="post" class="needs-validation">
            <div class="row gx-md-5 personal-details">
                <!-- Dados Pessoais -->
                <div class="col-xs-12 col-md-6">
                    <h4>Dados Pessoais |</h4>
                    <!-- Nome -->
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome-glow" name="nome" required value="<?php echo htmlspecialchars($nomeValue); ?>">
                    <!-- CPF -->
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required value="<?php echo htmlspecialchars($cpfValue); ?>">
                    <!-- Email -->
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($emailValue); ?>">
                    <!-- Telefone -->
                    <label for="telefone">Telefone:</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" required value="<?php echo htmlspecialchars($telefoneValue); ?>">
                    <!-- Data de Nascimento -->
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required value="<?php echo htmlspecialchars($nascimentoValue); ?>">
                </div>
                <!-- Formulário para os dados financeiros -->
                <div class="col-xs-12 col-md-6" id="financial-details">
                    <h4>Financiamento |</h4>
                    <!-- Valor da Compra -->
                    <label for="valor_compra">Valor da Compra:</label>
                    <input type="text" class="form-control" id="valor_compra" name="valor_compra" data-type="currency" required disabled>
                    <!-- Taxa de Juros -->
                    <label for="taxa_juros">Taxa de Juros (% ao mês):</label>
                    <input type="text" class="form-control" id="taxa_juros" name="taxa_juros" required pattern="\d+(,\d{1,2})?" title="Use vírgula para separar os decimais. Exemplo: De 1.5 para 1,5.">
                    <!-- Número de Parcelas -->
                    <label for="num_parcelas">Número de Parcelas:</label>
                    <input type="number" class="form-control" id="num_parcelas" name="num_parcelas" required disabled>
                    <!-- Valor de Entrada -->
                    <label for="valor_entrada">Valor de Entrada:</label>
                    <input type="text" class="form-control" id="valor_entrada" name="valor_entrada" data-type="currency" required disabled>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" id="simularButton" disabled>Simular Financiamento</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
if (isset($_SESSION['simulacoes']) && !empty($_SESSION['simulacoes'])) {
    echo "<h3>Resultados das Simulações</h3> ";

    // Botão "Limpar Tudo" 
    echo '<form method="post" action=""><button type="submit" name="limpar" class="btn">Limpar Tudo</button></form>';

    foreach ($_SESSION['simulacoes'] as $simulacao) {
        // Percorre todas as simulações armazenadas na sessão em ordem inversa (a mais recente primeiro)
        
        echo "<div class='row mb-4 cenario'>";
        
        // Detalhes da simulação com verificações
        $valorCompra = $simulacao['dados_financeiros']['valor_compra'] ?? 0;
        $taxaJuros = $simulacao['dados_financeiros']['taxa_juros'] ?? 0;
        $numParcelas = $simulacao['dados_financeiros']['num_parcelas'] ?? 0;
        $valorEntrada = $simulacao['dados_financeiros']['valor_entrada'] ?? 0;
        
        echo "<h3>Cálculos</h3> ";
        echo "<div style='border-bottom: 2px solid black;'></div>";
        
        echo "<div class='p-3'>";
        echo "<div class='row' id='center'>";
        echo "<div class='col'><strong>| Valor da Compra: R$ " . number_format((float)$valorCompra, 2, ',', '.') . " |</strong></div>";
        echo "<div class='col'><strong>| Taxa de Juros (ao mês): " . number_format((float)$taxaJuros, 2, ',', '.') . "% |</strong></div>";
        echo "<div class='col'><strong>| Número de Parcelas: " . $numParcelas . "x |</strong></div>";
        echo "<div class='col'><strong>| Entrada: R$ " . number_format((float)$valorEntrada, 2, ',', '.') . " | </strong></div>";
        echo "</div>"; 
        echo "</div>"; 
        echo "<div style='border-bottom: 2px solid black; margin-bottom: 20px'></div>";

        // Cenário 1
        echo "<div class='col-md-4 cenariox'>";
        echo "<strong>1º Cenário | </strong><br>";
        echo "<p>Este cenário não calcula o valor de entrada. O valor é dividido em parcelas, a partir de uma taxa por mês.</p>";
        echo "<strong>TOTAL: R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['total1'], 2, ',', '.')) . " | " . $numParcelas . "x R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['pmt1'], 2, ',', '.')) . "</strong><br>";
        echo "</div>"; 

        // Cenário 2
        echo "<div class='col-md-4 cenariox'>";
        echo "<strong>2º Cenário |</strong><br>";
        echo "<p>Este cenário exige o valor de entrada. Se não houver nenhuma entrada o resultado será igual ao 1º Cenário.</p>";
        echo "<strong>TOTAL: R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['total2'], 2, ',', '.')) . " | (" . $numParcelas . "x R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['pmt2'], 2, ',', '.')) . " + R$" . number_format((float)$valorEntrada, 2, ',', '.') . ")</strong><br>";
        echo "</div>"; 

        // Cenário 3
        echo "<div class='col-md-4 cenariox'>";
        echo "<strong>3º Cenário |</strong><br>";
        echo "<p>Neste cenário o valor de entrada é igual ao valor das parcelas subsequentes.</p>";
        echo "<strong>TOTAL: R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['total3'], 2, ',', '.')) . " | (" . $numParcelas . "x R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['pmt3'], 2, ',', '.')) . " + R$" . htmlspecialchars(number_format($simulacao['dados_financeiros']['pmt3'], 2, ',', '.')) . ")</strong><br>";
        echo "</div>"; 
        echo "<div style='border-bottom: 2px solid black; margin-bottom: 20px;'></div>";

        //MARKETING AREA
        echo "<div class='mb-1 p-3 cenario'>";
        echo "<strong>Dados Usados em Marketing:</strong><br><br>";
        echo "<strong>Nome:</strong> " . htmlspecialchars($simulacao['dados_pessoais']['nome']) . "<br>";
        echo "<strong>CPF:</strong> " . htmlspecialchars($simulacao['dados_pessoais']['cpf']) . "<br>";
        echo "<strong>Email:</strong> " . htmlspecialchars($simulacao['dados_pessoais']['email']) . "<br>";
        echo "<strong>Telefone:</strong> " . htmlspecialchars($simulacao['dados_pessoais']['telefone']) . "<br>";
        echo "<strong>Data de Nascimento:</strong> " . htmlspecialchars($simulacao['dados_pessoais']['data_nascimento']) . "<br>";
        echo "</div>"; 
        echo "</div>"; 
    }
}
?>
<footer class="container">
    <img src="css/img/myczdevs.png" alt="meulogo" class="imagem-footer">
</footer>
<!-- Bootstrap JS Local -->
<script src="css/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
