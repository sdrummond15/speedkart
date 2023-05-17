<?php

defined('_JEXEC') or die('Restricted access');

$count = 1;
$qtdmelhorvolta = 0;
$qtdeetapas = $this->qtdeetapas;
$qtdeetapas = $qtdeetapas[0]->qtdeetapas;
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
        $minpontos1 = 33;
        $minpontos2 = 33;
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

        $rapidas = CompetitionsModelCompetitions::getRapidas($etapas->etapa);
        foreach ($rapidas as $ptrapidas) {
            if ($pilotoequipe->id_piloto == $ptrapidas->id_piloto) {
                $melhor = $melhor + 0.5;
                $totpontos = $totpontos + 0.5;
                $melhoreq = $melhoreq + 0.5;
                $totpontoseq = $totpontoseq + 0.5;
            }
        }
        $descarte = CompetitionsModelCompetitions::getDescartes($etapas->etapa, $pilotoequipe->id_piloto);
        $desc_publis = 1;
        if (empty($descarte)) {
            $pontos = 0;
        } else {
            $pontos = $descarte[0]->pontos;
            $desc_publis = $descarte[0]->published;
        }
        if (($minpontos1 > $pontos) and ($desc_publis == 1)) {
            $minpontos2 = $minpontos1;
            $minpontos1 = $pontos;
        } else if (($minpontos2 > $pontos) and ($desc_publis == 1)) {
            $minpontos2 = $pontos;
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

///////////////////////////////////////////////////////////////////////////////
echo '<h1>Classifica&ccedil;&atilde;o por Equipes</h1>';
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
//echo '<th class="rotate"><div><span>100% Participa&ccedil;&atilde;o</span></div></th>';
echo '<th class="rotate"><div><span>Puni&ccedil;&atilde;o </span></div></th>';
echo '<th class="rotate"><div><span>Descarte </span></div></th>';
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
//echo '<td>BN</td>';
echo '<td>PN</td>';
echo '<td>DSC</td>';
echo '<td>PTS</td>';

echo '</tr>';

echo '<tr>';
//print_r($this->equipepiloto);
foreach ($this->equipepiloto as $equipepiloto) {
    $totpontoseq = 0;
    $deducaoeq = 0;
    $melhoreseq = 0;
    $bonusparteq = 0;
    $descarteeq = 0;
    foreach ($classificaeq as $classificaasc) {
        if ($classificaasc->id_equipe == $equipepiloto->id_team) {
            $totpontoseq = $totpontoseq + $classificaasc->totpontos;
            $deducaoeq = $deducaoeq + $classificaasc->deducao;
            $melhoreseq = $melhoreseq + $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;
            //$bonusparteq = $bonusparteq + $classificaasc->bonuspart;

        }
    }
    $ptavulso = CompetitionsModelCompetitions::getEquipeAvulso($equipepiloto->id_team);
    if (!empty($ptavulso)) {
        $totpontoseq = $totpontoseq + $ptavulso[0]->pontos;
    }
    //  echo $pilotoequipe->id_piloto;
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

    $minpontos1 = 66;
    $minpontos2 = 66;

    foreach ($this->etapas as $etapas) {

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipe($classificaeqasc->id_equipe, $etapas->etapa);

        if (($minpontos1 > $ptetapa[0]->pontoequipe)) {
            $minpontos2 = $minpontos1;
            $minpontos1 = $ptetapa[0]->pontoequipe;
        }else if ($minpontos2 > $ptetapa[0]->pontoequipe) {
            $minpontos2 = $ptetapa[0]->pontoequipe;
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
//print_r($classificaeq);

$countasc = 1;

foreach ($classificaequipe as $classificaeqasc) {
    echo '<tr>';
    echo '<td>' . $countasc . '</td>';
    echo '<td>' . $classificaeqasc->equipe . '</td>';
    foreach ($this->etapas as $etapas) {

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipe($classificaeqasc->id_equipe, $etapas->etapa);

        if (empty($ptetapa)) {
            echo '<td>0</td>';
        } else {
            echo '<td>' . $ptetapa[0]->pontoequipe . '</td>';
        }

    }

    if ($classificaeqasc->melhoreseq == 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . str_replace('.', ',', $classificaeqasc->melhoreseq) . '</td>';

    if ($classificaeqasc->deducaoeq > 0) {
        $corded = 'vermelho';
    } else {
        $corded = 'transp';
    }
    echo '<td class="' . $corded . '">' . $classificaeqasc->deducaoeq . '</td>';


    echo '<td class="backvermelho">' . $classificaeqasc->descarteEquipe . '</td>';
    $totpontoseq = $classificaeqasc->totpontoseq;
    echo '<td class="azul">' . str_replace('.', ',', $totpontoseq) . '</td></tr>';
    $countasc++;

}
echo '</table>';
echo '</div>';
?>