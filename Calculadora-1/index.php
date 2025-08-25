<?php
// calculadora_pj_vs_clt_simplificada.php

function brl($v){ return 'R$ '.number_format((float)$v, 2, ',', '.'); }

// Entrada
$salario_clt = isset($_POST['salario_clt']) ? (float)str_replace([',','.'],['.',''],$_POST['salario_clt']) : 5000;

// Parâmetros fixos (simples)
$fgts = 0.08;            // 8%
$inss_patronal = 0.20;   // 20%
$decimo_terceiro = $salario_clt/12;
$ferias = ($salario_clt + ($salario_clt/3)) / 12;
$beneficios = 1000;      // valor estimado (vale + saúde)
$contabilidade = 300;
$aliq_simples = 0.06;    // 6%
$perc_prolabore = 0.28;  // 28%
$aliq_inss_pj = 0.11;    // 11%

// Custo CLT mensal equivalente
$C = $salario_clt + $decimo_terceiro + $ferias + ($salario_clt*$fgts) + ($salario_clt*$inss_patronal) + $beneficios;

// Equação para PJ
$den = 1 - $aliq_simples - ($aliq_inss_pj * $perc_prolabore);
$pj = ($C + $contabilidade) / $den;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Calculadora PJ vs CLT</title>
</head>
<body>
  <h1>Calculadora PJ vs CLT (Simplificada)</h1>
  <form method="post">
    <label>Salário CLT desejado:</label>
    <input type="text" name="salario_clt" value="<?=number_format($salario_clt,2,',','.')?>">
    <button type="submit">Calcular</button>
  </form>

  <h2>Resultado:</h2>
  <p>Para um salário CLT de <strong><?=brl($salario_clt)?></strong>, você precisaria faturar como PJ aproximadamente:</p>
  <h3><?=brl($pj)?></h3>

  <h2>Detalhes:</h2>
  <ul>
    <li>13º proporcional: <?=brl($decimo_terceiro)?></li>
    <li>Férias + 1/3 proporcional: <?=brl($ferias)?></li>
    <li>FGTS (8%): <?=brl($salario_clt*$fgts)?></li>
    <li>INSS Patronal (20%): <?=brl($salario_clt*$inss_patronal)?></li>
    <li>Benefícios estimados: <?=brl($beneficios)?></li>
    <li>Contabilidade: <?=brl($contabilidade)?></li>
  </ul>
</body>
</html>
