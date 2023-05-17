<div class="qualifpilot">
    <?php
    $count = 1;
    $pilotos = '';
    foreach ($qualificationpilot as $qualificationpilot1) {
        $etapa = $qualificationpilot1->etapa;
        $id_etapa = $qualificationpilot1->id_etapa;
        $podio = $qualificationpilot1->podio;
        if ($count <= 5) {
            $pilotos .= '<p>' . $count . 'º Lugar  -  ' . $qualificationpilot1->piloto . '  -  ' . $qualificationpilot1->equipe . '</p>';
        }
        $count++;

    }
    ?>
    <h1>Qualificação da <?php echo $etapa; ?></h1>
    <div class="imagepilot" style="background: url('<?php echo (!empty($podio)) ? $podio : 'images/podium/default.jpg'; ?>')"></div>
    <?php echo $pilotos; ?>
    <p><a href="index.php/campeonato/todas-etapas/stage?id_stage=<?php echo $id_etapa; ?>">Confira a CLASSIFICAÇÃO >>></a></p>
</div>
