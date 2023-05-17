<?php

defined('_JEXEC') or die('Restricted access');

$count = 1;
$qtdmelhorvolta = 0;
echo '<div class="classificacao">';
echo '<h1>Classifica&ccedil;&atilde;o por Pilotos - FAST</h1>';
echo '<table>';
echo '<tr>';
echo '<th class="rotate"><div><span>Posi&ccedil;&atilde;o</span></div></th>';
echo '<th>Pilotos</th>';
echo '<th>Equipes</th>';

$classifica = array();
foreach ($this->etapas as $etapas) {
    $datas = strtotime($etapas->data);
    $ultimaetapa = $etapas->etapa;
    $dia = date('d', $datas);
    $mes = date('m', $datas);
    switch ($mes) {
        case 01:
            $m = 'Janeiro';
            break;
        case 02:
            $m = 'Fevereiro';
            break;
        case 03:
            $m = 'Março';
            break;
        case 04:
            $m = 'Abril';
            break;
        case 05:
            $m = 'Maio';
            break;
        case 06:
            $m = 'Junho';
            break;
        case 07:
            $m = 'Julho';
            break;
        case 8:
            $m = 'Agosto';
            break;
        case 9:
            $m = 'Setembro';
            break;
        case 10:
            $m = 'Outubro';
            break;
        case 11:
            $m = 'Novembro';
            break;
        case 12:
            $m = 'Dezembro';
            break;
    }
    echo '<th class="rotate"><div><span>' . $dia . ' de ' . $m . '</span></div></th>';
}

echo '<th class="rotate"><div><span>Melhor Volta</span></div></th>';
//echo '<th class="rotate"><div><span>100% Participa&ccedil;&atilde;o</span></div></th>';
echo '<th class="rotate"><div><span>Puni&ccedil;&atilde;o</span></div></th>';
echo '<th class="rotate"><div><span>Descarte 1</span></div></th>';
echo '<th class="rotate"><div><span>Descarte 2</span></div></th>';
echo '<th>Total</th>';

echo '</tr>';

echo '<tr class="cinza">';

echo '<td colspan=3></td>';
$countetapas = 0;
foreach ($this->etapas as $etapas) {
    $countetapas = $countetapas + 1;
    echo '<td>' . $countetapas . '&ordm;</td>';
}

echo '<td>VR</td>';
//echo '<td>GRUPO</td>';
echo '<td>PN</td>';
echo '<td>DSC1</td>';
echo '<td>DSC2</td>';
echo '<td>PTS</td>';

echo '</tr>';

//Pegando PILOTOS
foreach ($this->pilotoequipe as $pilotoequipe) {

    $totpontos = 0;
    $totpontoseq = 0;

    $minpontos1 = 0;
    $minpontos2 = 0;
    if ($countetapas > 2) {
        $minpontos1 = 30;
        //$minpontos2 = 30;
    }

    //Pegando PONTOS
    foreach ($this->pontos as $pontos) {
        //Pegando PONTOS de acordo com PILOTO
        if ($pontos->id_piloto == $pilotoequipe->id_piloto) {
            //Pegando ETAPAS
            foreach ($this->etapas as $etapas) {
                //Pegando ETAPAS de acordo com PONTO
                if ($pontos->etapa == $etapas->etapa) {
                    $totpontos = $totpontos + $pontos->pontos;
                    $totpontoseq = $totpontoseq + $pontos->pontos;
                }
            }
        }
    }

    $deducao = 0;
    $deducaoeq = 0;
    $punic = 1;
    foreach ($this->punicao as $punicao) {
        if ($punicao->id_piloto == $pilotoequipe->id_piloto) {

            $deducao = $deducao + $punicao->deducao;
            $totpontos = $totpontos - $punicao->deducao;
            $deducaoeq = $deducaoeq + $punicao->deducao;
            $totpontoseq = $totpontoseq - $punicao->deducao;
            $punic = 1;
        }
    }
    $bonuspart = 0;
    $qtdepiloto = CompetitionsModelCompetitions::getQtdePiloto($pilotoequipe->id_piloto);

    $bonusmelhorvolta = 0;
    $bonusmelhorvoltaeq = 0;
    foreach ($this->melhortempo as $melhortempo) {
        if ($pilotoequipe->id_piloto == $melhortempo->id_piloto) {
            $bonusmelhorvolta++;
            $bonusmelhorvoltaeq++;
        }
    }
    if ($bonusmelhorvolta > 0) {
        //echo $bonus
        $totpontos = $totpontos + $bonusmelhorvolta;
        $totpontoseq = $totpontoseq + $bonusmelhorvolta;
    }
    if ($bonusmelhorvoltaeq > 0) {
        //echo $bonus
        //  $totpontoseq = $totpontoseq + $bonusmelhorvoltaeq;
    }
    $qtdmelhorvolta = 0;
    $melhor = 0;
    $qtdmelhorvoltaeq = 0;
    $melhoreq = 0;
    foreach ($this->etapas as $etapas) {

        $descarte = CompetitionsModelCompetitions::getDescartes($etapas->etapa, $pilotoequipe->id_piloto);
        $desc_publis = 1;
        if (empty($descarte)) {
            $pontos = 0;
        } else {
            $pontos = $descarte[0]->pontos;
            $desc_publis = $descarte[0]->published;
        }
        if (($minpontos1 > $pontos) and ($desc_publis == 1)) {
           // $minpontos2 = $minpontos1;
            $minpontos1 = $pontos;
        } else if (($minpontos2 > $pontos) and ($desc_publis == 1)) {
           // $minpontos2 = $pontos;
        }
    };
    //  echo $pilotoequipe->id_piloto;
    $classifica[$count] = new stdClass();
    $classifica[$count]->totpontos = $totpontos - $minpontos1 - $minpontos2;
    $classifica[$count]->id_piloto = $pilotoequipe->id_piloto;
    $classifica[$count]->piloto = $pilotoequipe->name_piloto;
    $classifica[$count]->id_equipe = $pilotoequipe->id_equipe;
    $classifica[$count]->equipe = $pilotoequipe->equipe;
    $classifica[$count]->bonusmelhorvolta = $bonusmelhorvolta;
    $classifica[$count]->bonusmelhorvolta25 = $melhor;
    $classifica[$count]->grupo = $pilotoequipe->grupo;
    $classifica[$count]->deducao = $deducao;
    $classifica[$count]->descarte1 = $minpontos1;
    $classifica[$count]->descarte2 = $minpontos2;

    $classificaeq[$count] = new stdClass();
    $classificaeq[$count]->totpontos = $totpontoseq;
    $classificaeq[$count]->id_piloto = $pilotoequipe->id_piloto;
    $classificaeq[$count]->piloto = $pilotoequipe->name_piloto;
    $classificaeq[$count]->id_equipe = $pilotoequipe->id_equipe;
    $classificaeq[$count]->equipe = $pilotoequipe->equipe;
    $classificaeq[$count]->bonusmelhorvolta = $bonusmelhorvoltaeq;
    $classificaeq[$count]->bonusmelhorvolta25 = $melhoreq;
    $classificaeq[$count]->grupo = $pilotoequipe->grupo;
    $classificaeq[$count]->deducao = $deducaoeq;
    $classificaeq[$count]->descarte1 = $minpontos1;
    $classificaeq[$count]->descarte2 = $minpontos2;

    $count++;
}


function sortByOrdering($obj1, $obj2)
{
    return $obj1->totpontos - $obj2->totpontos;
}

usort($classifica, 'sortByOrdering');
arsort($classifica);
//print_r($classifica);
$countasc = 1;
$cor = '';
$corded = '';
foreach ($classifica as $classificaasc) {

    echo '<tr>';
    echo '<td>' . $countasc . '</td>';
    echo '<td>' . $classificaasc->piloto . '</td>';
    echo '<td>' . $classificaasc->equipe . '</td>';
    foreach ($this->etapas as $etapas) {
        $bonusml = $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;
        $ptetapa = CompetitionsModelCompetitions::getPtetapa($etapas->etapa, $classificaasc->id_piloto);
        if (empty($ptetapa)) {
            echo '<td>0</td>';
        } else {
            if ($ptetapa[0]->pontos == 33) {
                $cor = 'verde';
            } elseif ($ptetapa[0]->pontos < 33 && $ptetapa[0]->pontos >= 26) {
                $cor = 'amarelo';
            } else {
                $cor = 'transp';
            }
            echo '<td class="' . $cor . '">' . $ptetapa[0]->pontos . '</td>';
        }
    }

    if ($bonusml == 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . str_replace('.', ',', $bonusml) . '</td>';

//    if ($classificaasc->bonuspart == 0){
//        $corded = 'vermelho';
//    }else{
//        $corded = 'transp';
//    }
//    echo '<td class="'.$corded.'">'.$classificaasc->grupo .'</td>';


    if ($classificaasc->deducao > 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . $classificaasc->deducao . '</td>';


    echo '<td class="backvermelho">' . $classificaasc->descarte1 . '</td>';
    echo '<td class="backvermelho">' . $classificaasc->descarte2 . '</td>';
    echo '<td class="azul">' . str_replace('.', ',', $classificaasc->totpontos) . '</td></tr>';
    $countasc++;
}


echo '</table>';


$count = 1;
$qtdmelhorvolta = 0;
echo '<div class="classificacao">';
echo '<h1>Classifica&ccedil;&atilde;o por Pilotos - FURIOUS</h1>';
echo '<table>';
echo '<tr>';
echo '<th class="rotate"><div><span>Posi&ccedil;&atilde;o</span></div></th>';
echo '<th>Pilotos</th>';
echo '<th>Equipes</th>';

$classifica = array();
foreach ($this->etapasfurious as $etapas) {
    $datas = strtotime($etapas->data);
    $ultimaetapa = $etapas->etapa;
    $dia = date('d', $datas);
    $mes = date('m', $datas);
    switch ($mes) {
        case 01:
            $m = 'Janeiro';
            break;
        case 02:
            $m = 'Fevereiro';
            break;
        case 03:
            $m = 'Março';
            break;
        case 04:
            $m = 'Abril';
            break;
        case 05:
            $m = 'Maio';
            break;
        case 06:
            $m = 'Junho';
            break;
        case 07:
            $m = 'Julho';
            break;
        case 8:
            $m = 'Agosto';
            break;
        case 9:
            $m = 'Setembro';
            break;
        case 10:
            $m = 'Outubro';
            break;
        case 11:
            $m = 'Novembro';
            break;
        case 12:
            $m = 'Dezembro';
            break;
    }
    echo '<th class="rotate"><div><span>' . $dia . ' de ' . $m . '</span></div></th>';
}

echo '<th class="rotate"><div><span>Melhor Volta</span></div></th>';
//echo '<th class="rotate"><div><span>100% Participa&ccedil;&atilde;o</span></div></th>';
echo '<th class="rotate"><div><span>Puni&ccedil;&atilde;o</span></div></th>';
echo '<th class="rotate"><div><span>Descarte 1</span></div></th>';
echo '<th class="rotate"><div><span>Descarte 2</span></div></th>';
echo '<th>Total</th>';

echo '</tr>';

echo '<tr class="cinza">';

echo '<td colspan=3></td>';
$countetapas = 0;
foreach ($this->etapasfurious as $etapas) {
    $countetapas = $countetapas + 1;
    echo '<td>' . $countetapas . '&ordm;</td>';
}

echo '<td>VR</td>';
//echo '<td>GRUPO</td>';
echo '<td>PN</td>';
echo '<td>DSC1</td>';
echo '<td>DSC2</td>';
echo '<td>PTS</td>';

echo '</tr>';

//Pegando PILOTOS
foreach ($this->pilotoequipefurious as $pilotoequipe) {

    $totpontos = 0;
    $totpontoseq = 0;

    $minpontos1 = 0;
    $minpontos2 = 0;
    if ($countetapas > 2) {
        $minpontos1 = 30;
       // $minpontos2 = 30;
    }

    //Pegando PONTOS
    foreach ($this->pontos as $pontos) {
        //Pegando PONTOS de acordo com PILOTO
        if ($pontos->id_piloto == $pilotoequipe->id_piloto) {
            //Pegando ETAPAS
            foreach ($this->etapasfurious as $etapas) {
                //Pegando ETAPAS de acordo com PONTO
                if ($pontos->etapa == $etapas->etapa) {
                    $totpontos = $totpontos + $pontos->pontos;
                    $totpontoseq = $totpontoseq + $pontos->pontos;
                }
            }
        }
    }

    $deducao = 0;
    $deducaoeq = 0;
    $punic = 1;
    foreach ($this->punicao as $punicao) {
        if ($punicao->id_piloto == $pilotoequipe->id_piloto) {

            $deducao = $deducao + $punicao->deducao;
            $totpontos = $totpontos - $punicao->deducao;
            $deducaoeq = $deducaoeq + $punicao->deducao;
            $totpontoseq = $totpontoseq - $punicao->deducao;
            $punic = 1;
        }
    }
    $bonuspart = 0;
    $qtdepiloto = CompetitionsModelCompetitions::getQtdePiloto($pilotoequipe->id_piloto);

    $bonusmelhorvolta = 0;
    $bonusmelhorvoltaeq = 0;
    foreach ($this->melhortempo as $melhortempo) {
        if ($pilotoequipe->id_piloto == $melhortempo->id_piloto) {
            $bonusmelhorvolta++;
            $bonusmelhorvoltaeq++;
        }
    }
    if ($bonusmelhorvolta > 0) {
        //echo $bonus
        $totpontos = $totpontos + $bonusmelhorvolta;
        $totpontoseq = $totpontoseq + $bonusmelhorvolta;
    }
    if ($bonusmelhorvoltaeq > 0) {
        //echo $bonus
        //  $totpontoseq = $totpontoseq + $bonusmelhorvoltaeq;
    }
    $qtdmelhorvolta = 0;
    $melhor = 0;
    $qtdmelhorvoltaeq = 0;
    $melhoreq = 0;
    foreach ($this->etapasfurious as $etapas) {

        $descarte = CompetitionsModelCompetitions::getDescartes($etapas->etapa, $pilotoequipe->id_piloto);
        $desc_publis = 1;
        if (empty($descarte)) {
            $pontos = 0;
        } else {
            $pontos = $descarte[0]->pontos;
            $desc_publis = $descarte[0]->published;
        }
        if (($minpontos1 > $pontos) and ($desc_publis == 1)) {
          //  $minpontos2 = $minpontos1;
            $minpontos1 = $pontos;
        }
    };
    //  echo $pilotoequipe->id_piloto;
    $classifica[$count] = new stdClass();
    $classifica[$count]->totpontos = $totpontos - $minpontos1 - $minpontos2;
    $classifica[$count]->id_piloto = $pilotoequipe->id_piloto;
    $classifica[$count]->piloto = $pilotoequipe->name_piloto;
    $classifica[$count]->id_equipe = $pilotoequipe->id_equipe;
    $classifica[$count]->equipe = $pilotoequipe->equipe;
    $classifica[$count]->bonusmelhorvolta = $bonusmelhorvolta;
    $classifica[$count]->bonusmelhorvolta25 = $melhor;
    $classifica[$count]->grupo = $pilotoequipe->grupo;
    $classifica[$count]->deducao = $deducao;
    $classifica[$count]->descarte1 = $minpontos1;
    $classifica[$count]->descarte2 = $minpontos2;

    $classificaeq[$count] = new stdClass();
    $classificaeq[$count]->totpontos = $totpontoseq;
    $classificaeq[$count]->id_piloto = $pilotoequipe->id_piloto;
    $classificaeq[$count]->piloto = $pilotoequipe->name_piloto;
    $classificaeq[$count]->id_equipe = $pilotoequipe->id_equipe;
    $classificaeq[$count]->equipe = $pilotoequipe->equipe;
    $classificaeq[$count]->bonusmelhorvolta = $bonusmelhorvoltaeq;
    $classificaeq[$count]->bonusmelhorvolta25 = $melhoreq;
    $classificaeq[$count]->grupo = $pilotoequipe->grupo;
    $classificaeq[$count]->deducao = $deducaoeq;
    $classificaeq[$count]->descarte1 = $minpontos1;
    $classificaeq[$count]->descarte2 = $minpontos2;

    $count++;
}


function sortByOrderingfurious($obj1, $obj2)
{
    return $obj1->totpontos - $obj2->totpontos;
}

usort($classifica, 'sortByOrderingfurious');
arsort($classifica);
//print_r($classifica);
$countasc = 1;
$cor = '';
$corded = '';
foreach ($classifica as $classificaasc) {

    echo '<tr>';
    echo '<td>' . $countasc . '</td>';
    echo '<td>' . $classificaasc->piloto . '</td>';
    echo '<td>' . $classificaasc->equipe . '</td>';
    foreach ($this->etapasfurious as $etapas) {
        $bonusml = $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;
        $ptetapa = CompetitionsModelCompetitions::getPtetapa($etapas->etapa, $classificaasc->id_piloto);
        if (empty($ptetapa)) {
            echo '<td>0</td>';
        } else {
            if ($ptetapa[0]->pontos == 33) {
                $cor = 'verde';
            } elseif ($ptetapa[0]->pontos < 33 && $ptetapa[0]->pontos >= 26) {
                $cor = 'amarelo';
            } else {
                $cor = 'transp';
            }
            echo '<td class="' . $cor . '">' . $ptetapa[0]->pontos . '</td>';
        }
    }

    if ($bonusml == 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . str_replace('.', ',', $bonusml) . '</td>';

//    if ($classificaasc->bonuspart == 0){
//        $corded = 'vermelho';
//    }else{
//        $corded = 'transp';
//    }
//    echo '<td class="'.$corded.'">'.$classificaasc->grupo .'</td>';


    if ($classificaasc->deducao > 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . $classificaasc->deducao . '</td>';


    echo '<td class="backvermelho">' . $classificaasc->descarte1 . '</td>';
    echo '<td class="backvermelho">' . $classificaasc->descarte2 . '</td>';
    echo '<td class="azul">' . str_replace('.', ',', $classificaasc->totpontos) . '</td></tr>';
    $countasc++;
}


echo '</table>';



///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
echo '<h1>Classifica&ccedil;&atilde;o por Equipes - FAST</h1>';
echo '<table>';
echo '<tr>';
echo '<th class="rotate"><div><span>Posi&ccedil;&atilde;o</span></div></th>';
echo '<th>Equipes</th>';
$counteq = 1;
foreach ($this->etapas as $etapas) {
    $datas = strtotime($etapas->data);
    $ultimaetapa = $etapas->etapa;
    $dia = date('d', $datas);
    $mes = date('m', $datas);
    switch ($mes) {
        case 01:
            $m = 'Janeiro';
            break;
        case 02:
            $m = 'Fevereiro';
            break;
        case 03:
            $m = 'Março';
            break;
        case 04:
            $m = 'Abril';
            break;
        case 05:
            $m = 'Maio';
            break;
        case 06:
            $m = 'Junho';
            break;
        case 07:
            $m = 'Julho';
            break;
        case 8:
            $m = 'Agosto';
            break;
        case 9:
            $m = 'Setembro';
            break;
        case 10:
            $m = 'Outubro';
            break;
        case 11:
            $m = 'Novembro';
            break;
        case 12:
            $m = 'Dezembro';
            break;
    }
    echo '<th class="rotate"><div><span>' . $dia . ' de ' . $m . '</th>';
}

echo '<th class="rotate"><div><span>Melhor Volta </span></div></th>';
echo '<th>Total</th>';

echo '</tr>';

echo '<tr class="cinza">';

echo '<td colspan=2></td>';
$countetapas = 0;
foreach ($this->etapas as $etapas) {
    $countetapas = $countetapas + 1;
    echo '<td>' . $countetapas . '&ordm;</td>';
}
echo '<td>VR</td>';
echo '<td>PTS</td>';

echo '</tr>';

echo '<tr>';
foreach ($this->equipepiloto as $equipepiloto) {
    $totpontoseq = 0;
    $melhoreseq = 0;
    $descarteeq = 0;
    foreach ($classificaeq as $classificaasc) {
        if ($classificaasc->id_equipe == $equipepiloto->id_team) {
            if ($countpilot < 2) {
            $totpontoseq = $totpontoseq + $classificaasc->totpontos;
            $melhoreseq = $melhoreseq + $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;
            $countpilot = 0;
            }
        }
    }
    $ptavulso = CompetitionsModelCompetitions::getEquipeAvulso($equipepiloto->id_team);
    if (!empty($ptavulso)) {
        $totpontoseq = $totpontoseq + $ptavulso[0]->pontos;
    }
    $classificaeqt[$counteq] = new stdClass();
    $classificaeqt[$counteq]->totpontoseq = $totpontoseq;
    $classificaeqt[$counteq]->id_equipe = $equipepiloto->id_team;
    $classificaeqt[$counteq]->equipe = $equipepiloto->equipe;
    $classificaeqt[$counteq]->melhoreseq = $melhoreseq;
    $classificaeqt[$counteq]->bonusparteq = $bonusparteq;
    $classificaeqt[$counteq]->deducaoeq = $deducaoeq;
    $counteq++;
}
$countequipe = 1;
foreach ($classificaeqt as $classificaeqasc) {

    foreach ($this->etapas as $etapas) {

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipe($classificaeqasc->id_equipe, $etapas->etapa);
        $countpilot = 0;
        foreach ($ptetapa as $ptetapapilot) {
            if ($countpilot < 2) {
                $totpontoseq = $totpontoseq + $ptetapapilot->pontospiloto;
            }
            $countpilot++;
        }

    }

    $descarteEquipe = $minpontos1 + $minpontos2;
    $totpontoseq = $classificaeqasc->totpontoseq - $descarteEquipe;

    $classificaequipe[$countequipe] = new stdClass();
    $classificaequipe[$countequipe]->totpontoseq = $totpontoseq;
    $classificaequipe[$countequipe]->descarteEquipe = $descarteEquipe;
    $classificaequipe[$countequipe]->id_equipe = $classificaeqasc->id_equipe;
    $classificaequipe[$countequipe]->equipe = $classificaeqasc->equipe;
    $classificaequipe[$countequipe]->melhoreseq = $classificaeqasc->melhoreseq;
    $classificaequipe[$countequipe]->bonusparteq = $classificaeqasc->bonusparteq;
    $classificaequipe[$countequipe]->deducaoeq = $classificaeqasc->deducaoeq;
    $countequipe++;
}

function sortByOrderingEq($obj1, $obj2)
{
    return $obj1->totpontoseq - $obj2->totpontoseq;
}

usort($classificaequipe, 'sortByOrderingEq');
arsort($classificaequipe);

$countasc = 1;



echo
'      </tr>
        <tr>
            <td>1</td>
            <td>Equipe 2 FAST</td>
            <td>39</td>
            <td>43</td>
            <td>53</td>
            <td class="transp">0</td>
            <td class="azul">135</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Equipe 3 FAST</td>
            <td>40</td>
            <td>32</td>
            <td>39</td>
            <td class="transp">1</td>
            <td class="azul">112</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Equipe 1 FAST</td>
            <td>46</td>
            <td>36</td>
            <td>29</td>
            <td class="transp">0</td>
            <td class="azul">111</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Equipe 6 FAST</td>
            <td>30</td>
            <td>51</td>
            <td>20</td>
            <td class="transp">0</td>
            <td class="azul">101</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Equipe 8 FAST</td>
            <td>31</td>
            <td>23</td>
            <td>43</td>
            <td class="transp">0</td>
            <td class="azul">97</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Equipe 4 FAST</td>
            <td>39</td>
            <td>32</td>
            <td>23</td>
            <td class="transp">0</td>
            <td class="azul">94</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Equipe 7 FAST</td>
            <td>11</td>
            <td>29</td>
            <td>37</td>
            <td class="transp">0</td>
            <td class="azul">77</td>
        </tr>
        <tr>
            <td>8</td>
            <td>Equipe 5 FAST</td>
            <td>30</td>
            <td>32</td>
            <td>0</td>
            <td class="transp">2</td>
            <td class="azul">64</td>
        </tr>
    </tbody>
</table>';
echo '<h1>Classifica&ccedil;&atilde;o por Equipes - Furious</h1>';
echo
'<table>
    <tbody>
        <tr>
            <th class="rotate"><div><span>Posição</span></div></th>
            <th>Equipes</th>
            <th class="rotate"><div><span>22 de Janeiro</span></div></th>
            <th class="rotate"><div><span>26 de Fevereiro</span></div></th>
            <th class="rotate"><div><span>19 de Março</span></div></th>
            <th class="rotate"><div><span>Melhor Volta </span></div></th>
            <th>Total</th>
        </tr>
        <tr class="cinza">
            <td colspan="2"></td>
            <td>1º</td>
            <td>2º</td>
            <td>3º</td>
            <td>VR</td>
            <td>PTS</td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td>1</td>
            <td>Equipe 6 Furious</td>
            <td>52</td>
            <td>53</td>
            <td>38</td>
            <td class="transp">0</td>
            <td class="azul">143</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Equipe 7 Furious</td>
            <td>39</td>
            <td>35</td>
            <td>35</td>
            <td class="transp">0</td>
            <td class="azul">109</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Equipe 1 Furious</td>
            <td>42</td>
            <td>33</td>
            <td>27</td>
            <td class="transp">0</td>
            <td class="azul">102</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Equipe 4 Furious</td>
            <td>35</td>
            <td>21</td>
            <td>42</td>
            <td class="transp">1</td>
            <td class="azul">99</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Equipe 10 Furious</td>
            <td>20</td>
            <td>35</td>
            <td>32</td>
            <td class="transp">0</td>
            <td class="azul">87</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Equipe 5 Furious</td>
            <td>8</td>
            <td>35</td>
            <td>30</td>
            <td class="transp">1</td>
            <td class="azul">74</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Equipe 3 Furious</td>
            <td>26</td>
            <td>11</td>
            <td>29</td>
            <td class="transp">0</td>
            <td class="azul">66</td>
        </tr>
        <tr>
            <td>8</td>
            <td>Equipe 11 Furious</td>
            <td>0</td>
            <td>39</td>
            <td>20</td>
            <td class="transp">1</td>
            <td class="azul">60</td>
        </tr>
        <tr>
            <td>9</td>
            <td>Equipe 8 Furious</td>
            <td>29</td>
            <td>14</td>
            <td>15</td>
            <td class="transp">0</td>
            <td class="azul">58</td>
        </tr>
        <tr>
            <td>10</td>
            <td>Equipe 9 Furious</td>
            <td>21</td>
            <td>13</td>
            <td>6</td>
            <td class="transp">0</td>
            <td class="azul">40</td>
        </tr>
        <tr>
            <td>11</td>
            <td>Equipe 2 Furious</td>
            <td>14</td>
            <td>9</td>
            <td>10</td>
            <td class="transp">0</td>
            <td class="azul">33</td>
        </tr>
    </tbody>
</table>';
echo '</div>';



?>