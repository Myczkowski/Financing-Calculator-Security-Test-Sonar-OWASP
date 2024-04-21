<?php
function calcularCF($taxa_juros, $num_parcelas) {
    $i = $taxa_juros / 100.0;
    return $i / (1 - pow((1 + $i), -$num_parcelas));
}

function calcularPMT($valor_financiado, $cf) {
    return $valor_financiado * $cf;
}

function calcularPMT_Cenario3($pv, $cf) {
    return ($pv * $cf) / (1 + $cf);
}

function calcularTotalFinanciamento($pmt, $num_parcelas, $valor_entrada = 0) {
    return ($pmt * $num_parcelas) + $valor_entrada;
}
?>
