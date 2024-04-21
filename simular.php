<?php
session_start();
include 'calculos.php';

function cleanNumber($number) {
    $number = str_replace(',', '.', $number);
    $number = preg_replace("/[^0-9\.]/", "", $number);
    return floatval($number);
}

// Capturando os dados do formulário
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';
$valor_compra = isset($_POST['valor_compra']) ? cleanNumber($_POST['valor_compra']) : 0;
$taxa_juros = isset($_POST['taxa_juros']) ? cleanNumber($_POST['taxa_juros']) : 0;
$num_parcelas = isset($_POST['num_parcelas']) ? intval($_POST['num_parcelas']) : 0;
$valor_entrada = isset($_POST['valor_entrada']) ? cleanNumber($_POST['valor_entrada']) : 0;

// Cálculos financeiros
$cf = calcularCF($taxa_juros, $num_parcelas);
$pmt_cenario1 = calcularPMT($valor_compra, $cf);
$pmt_cenario2 = calcularPMT($valor_compra - $valor_entrada, $cf);
$pmt_cenario3 = calcularPMT_Cenario3($valor_compra, $cf); // Aqui o valor de entrada para o cenario 3 é determinado

// Calcula o valor de entrada como sendo o mesmo que o PMT do cenário 3
$valor_entrada_cenario3 = $pmt_cenario3;

$total_financiamento1 = calcularTotalFinanciamento($pmt_cenario1, $num_parcelas);
$total_financiamento2 = calcularTotalFinanciamento($pmt_cenario2, $num_parcelas, $valor_entrada);
$total_financiamento3 = calcularTotalFinanciamento($pmt_cenario3, $num_parcelas, $valor_entrada_cenario3);

// Adiciona a nova simulação no início do array
if (!isset($_SESSION['simulacoes'])) {
    $_SESSION['simulacoes'] = [];
}

array_unshift($_SESSION['simulacoes'], [
    'dados_pessoais' => [
        'nome' => $nome,
        'cpf' => $cpf,
        'email' => $email,
        'telefone' => $telefone,
        'data_nascimento' => $data_nascimento
    ],
    'dados_financeiros' => [
        'valor_compra' => $valor_compra,
        'taxa_juros' => $taxa_juros,
        'num_parcelas' => $num_parcelas,
        'valor_entrada' => $valor_entrada,
        'cf' => $cf,
        'pmt1' => $pmt_cenario1,
        'total1' => $total_financiamento1,
        'pmt2' => $pmt_cenario2,
        'total2' => $total_financiamento2,
        'pmt3' => $pmt_cenario3,
        'total3' => $total_financiamento3
    ]
]);

// Armazenando os dados submetidos na sessão para repopulação
$_SESSION['dados_pessoais'] = [
    'nome' => $nome,
    'cpf' => $cpf,
    'email' => $email,
    'telefone' => $telefone,
    'data_nascimento' => $data_nascimento,
];

header('Location: index.php');
exit;
?>
