<div class="pilotdetail">

    <?php

    foreach ($this->pilotodetail as $pilot_detail) {
        echo '<h1>' . $pilot_detail->nome;
        if (!empty($pilot_detail->equipe)) {
            echo ' - Equipe ' . $pilot_detail->equipe . '</h1>';
        } else {
            echo ' - Sem Equipe</h1>';
        }

        if (!empty($pilot_detail->pilotokart)) {
            $piloto_img = $pilot_detail->pilotokart;
        } else {
            $piloto_img = 'images/pilotos/kartpiloto/default.jpg';
        }

        echo '<div class="detail_imgkart" style="background: url(' . $piloto_img . ')"></div>';
    }


    $piloto = $_GET['id_piloto'];
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('qtd_racing,qtd_1,qtd_2,qtd_3,qtd_4,qtd_5,qtd_best_lap,qtd_best2_5,historic,all_points');
    $query->from('#__previous');
    $query->where('id_pilot = ' . $piloto);
    $db->setQuery($query);
    $anteriores = $db->loadObjectList();

    $qtd_racing = 0;
    $qtd_1 = 0;
    $qtd_2 = 0;
    $qtd_3 = 0;
    $qtd_4 = 0;
    $qtd_5 = 0;
    $qtd_best_lap = 0;
    $qtd_best2_5 = 0;
    $historic = 0;
    $all_points = 0;

    if (!empty($anteriores)) {
        $qtd_racing = $anteriores[0]->qtd_racing;
        $qtd_1 = $anteriores[0]->qtd_1;
        $qtd_2 = $anteriores[0]->qtd_2;
        $qtd_3 = $anteriores[0]->qtd_3;
        $qtd_4 = $anteriores[0]->qtd_4;
        $qtd_5 = $anteriores[0]->qtd_5;
        $qtd_best_lap = $anteriores[0]->qtd_best_lap;
        $qtd_best2_5 = $anteriores[0]->qtd_best2_5;
        $historic = $anteriores[0]->historic;
        $all_points = $anteriores[0]->all_points;
    }

    echo '<div id="content_1" class="details">';
    foreach ($this->corridas as $qtd_corridas) {
        $corridas = $qtd_corridas->qtd_corridas += $qtd_racing;
        if (!empty($corridas)) {
            echo '<h2>Corridas Disputadas: ' . $corridas . '</h2>';
        } else {
            echo '<div class="estreante">Estreante</div>';
        }
    }

    foreach ($this->primeiro as $firsts) {
        if (!empty($corridas)) {
            $primeiro = $firsts->firsts + $qtd_1;
            echo '<p>Vitórias: ' . $primeiro . '</p>';
        }
    }

    foreach ($this->segundo as $second) {
        if (!empty($corridas)) {
            $segundo = $second->second + $qtd_2;
            echo '<p>2º Lugar: ' . $segundo . '</p>';
        }
    }

    foreach ($this->terceiro as $third) {
        if (!empty($corridas)) {
            $terceiro = $third->third + $qtd_3;
            echo '<p>3º Lugar: ' . $terceiro . '</p>';
        }
    }

    foreach ($this->quarto as $fourth) {
        if (!empty($corridas)) {
            $quarto = $fourth->fourth + $qtd_4;
            echo '<p>4º Lugar: ' . $quarto . '</p>';
        }
    }

    foreach ($this->quinto as $fifth) {
        if (!empty($corridas)) {
            $quinto = $fifth->fifth + $qtd_5;
            echo '<p>5º Lugar: ' . $quinto . '</p>';
        }
    }

    $totalpodio = $primeiro + $segundo + $terceiro + $quarto + $quinto;
    echo '<p>Total de Pódio: ' . $totalpodio . '</p>';

    foreach ($this->melhorvolta as $best_lap) {
        if (!empty($corridas)) {
            $melhor_volta = $best_lap->best_lap + $qtd_best_lap;
            echo '<p>Melhor Volta: ' . $melhor_volta . '</p>';
        }
    }

    foreach ($this->melhores2a5 as $best_lap_2_5) {
        if (!empty($corridas)) {
            $melhores2a5 = $best_lap_2_5->best_lap_2_5 + $qtd_best2_5;
            echo '<p>Entre 2ª e 5ª Melhores Voltas: ' . $melhores2a5 . '</p>';
        }
    }

    foreach ($this->totalpontos as $total_pontos) {
        if (!empty($corridas)) {
            $total = $total_pontos->points + $all_points;
            // echo '<p>Total de Pontos: '.$total.'</p>';
        }
    }

    foreach ($this->historico as $historico) {
        if (!empty($corridas)) {
            echo '<h3>Histórico</h3>';
            echo '<p>';
            echo str_replace(";", "</p><p>", $historico->historico);
            echo '</p>';
        }
    }

    echo '</div>';


    echo '<div class="voltar"><a href="javascript:history.go(-1)"><<< Voltar</a></div>';
    ?>

</div>