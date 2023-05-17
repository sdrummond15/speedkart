<div class="stagedetail">
    <h1>Detalhes da Etapa</h1>
    <?php
    $countmotivo = 0;
    ?>
    <table>
        <thead>
        <tr>
            <td>Posição</td>
            <td>Grid de Largada</td>
            <td>Desempenho</td>
            <td>Piloto</td>
            <td>Voltas</td>
            <td>Pontos</td>
            <td>Punição</td>
            <td>Diferença</td>
            <td>Melhor Volta</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->stagedetail as $stage_detail):
            $dif = $stage_detail->grid - $stage_detail->posicao;
            if ($dif < 0) {
                $negativo = 'negativo';
            } else {
                $negativo = 'positivo';
            }

            $best_volta = '';
            if ($stage_detail->position_best_lap == 1) {
                $best_volta = 'class="verde"';
            } else if ($stage_detail->position_best_lap < 6) {
                $best_volta = 'class="azul"';
            }
            ?>
            <tr>
                <td><?php echo $stage_detail->posicao; ?></td>
                <td><?php echo $stage_detail->grid; ?></td>
                <td class="<?php echo $negativo; ?>"><?php echo $dif; ?></td>
                <td class="left"><?php echo $stage_detail->piloto; ?></td>
                <td><?php echo $stage_detail->voltas; ?></td>
                <td><?php echo $stage_detail->pontos; ?></td>
                <td><?php echo $stage_detail->deducao; ?></td>
                <td><?php echo $stage_detail->diferenca; ?></td>
                <td <?php echo $best_volta; ?>><?php echo $stage_detail->melhor_volta; ?></td>
            </tr>
            <?php
            if (!empty($stage_detail->motivo)) {
                $countmotivo++;
            }
        endforeach;
        ?>
        </tbody>
    </table>

    <div class="bests">
        <h1>MELHORES VOLTAS</h1>
        <?php
        $count = 1;
        foreach ($this->firsts as $firsts):
            switch ($count) {
                case 1:
                    $colocacao = '1ª Melhor Volta';
                    break;
                case 2:
                    $colocacao = '2ª Melhor Volta';
                    break;
                case 3:
                    $colocacao = '3ª Melhor Volta';
                    break;
                case 4:
                    $colocacao = '4ª Melhor Volta';
                    break;
                case 5:
                    $colocacao = '5ª Melhor Volta';
                    break;
            }
            ?>

            <div class="best">
                <h2><?php echo $colocacao; ?></h2>
                <div class="img_best">
                    <a href="index.php/campeonato/pilotos/pilot?id_piloto=<?php echo $firsts->id_piloto; ?>" style="background:url('<?php echo (!empty($firsts->foto)) ? JUri::base().$firsts->foto : JUri::base().'images/pilotos/default.jpg'; ?>');"></a>
                </div>
                <h4>
                    <a href="index.php/campeonato/pilotos/pilot?id_piloto=<?php echo $firsts->id_piloto; ?>"><?php echo $firsts->piloto; ?></a>
                </h4>
                <p><?php echo $firsts->equipe; ?></p>
                <h3>Tempo: <?php echo $firsts->melhor_volta; ?></h3>
            </div>
            <?php
            $count++;
        endforeach;
        if (!empty($countmotivo)):
            ?>

            <div class="punidos">
                <h1>PUNIÇÕES</h1>
                <table>
                    <thead>
                    <tr>
                        <td>Piloto</td>
                        <td>Pontos</td>
                        <td>Descrição do motivo da punição</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->deductions as $deductions):
                        if (!empty($deductions->motivo)):
                        ?>
                        <tr>
                            <td><?php echo $deductions->piloto; ?></td>
                            <td><?php echo ($deductions->deducao == 0) ? '--' : $deductions->deducao; ?></td>
                            <td><?php echo $deductions->motivo; ?></td>
                        </tr>
                        <?php
                        endif;
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        endif;
        ?>
    </div>
    <div class="voltar"><a href="javascript:history.go(-1)"><<< Voltar</a></div>
</div>