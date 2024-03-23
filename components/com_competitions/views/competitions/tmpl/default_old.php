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

       // $minpontos2 = 30;

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

        if ($etapas->etapa < 65){
	if (empty($descarte)) {

            $pontos = 0;

        } else {

            $pontos = $descarte[0]->pontos;

            $desc_publis = $descarte[0]->published;

        }

        if (($minpontos1 > $pontos) and ($desc_publis == 1)) {

            $minpontos1 = $pontos;

           // $minpontos1 = $pontos;

        } else if (($minpontos1 > $pontos) and ($desc_publis == 1)) {

            //$minpontos2 = $pontos;

        }

        }
    };

    

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



$countasc = 1;

$cor = '';

$corded = '';

foreach ($classifica as $classificaasc) {





    echo '<tr>';

    echo '<td>' . $countasc . '</td>';

    echo '<td>' . $classificaasc->piloto . '</td>';

    echo '<td>' . substr($classificaasc->equipe,0,9) . '</td>';

    foreach ($this->etapas as $etapas) {

        $bonusml = $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;

        $ptetapa = CompetitionsModelCompetitions::getPtetapa($etapas->etapa, $classificaasc->id_piloto);

        if (empty($ptetapa)) {

            echo '<td>0</td>';

        } else {

            if ($ptetapa[0]->pontos == 30) {

                $cor = 'verde';

            } elseif ($ptetapa[0]->pontos < 30 && $ptetapa[0]->pontos >= 21) {

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

$qtdeetapas = $this->qtdeetapas;

$qtdeetapas = $qtdeetapas[0]->qtdeetapas;

echo '<div class="classificacao">';

echo '<h1>Classifica&ccedil;&atilde;o por Pilotos - FURIOUS</h1>';

echo '<table>';

echo '<tr>';

echo '<th class="rotate"><div><span>Posi&ccedil;&atilde;o</span></div></th>';

echo '<th>Pilotos</th>';

echo '<th>Equipes</th>';



$classificafurious = array();

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

         // $totpontoseq = $totpontoseq + $bonusmelhorvoltaeq;

    }

    $qtdmelhorvolta = 0;

    $melhor = 0;

    $qtdmelhorvoltaeq = 0;

    $melhoreq = 0;

    foreach ($this->etapasfurious as $etapas) {

        $descarte = CompetitionsModelCompetitions::getDescartes($etapas->etapa, $pilotoequipe->id_piloto);

        $desc_publis = 1;

        if ($etapas->etapa < 65){

	if (empty($descarte)) {

            $pontos = 0;

        } else {

            $pontos = $descarte[0]->pontos;

            $desc_publis = $descarte[0]->published;

        }

        if (($minpontos1 > $pontos) and ($desc_publis == 1)) {

            $minpontos1 = $pontos;

           // $minpontos1 = $pontos;

        } else if (($minpontos1 > $pontos) and ($desc_publis == 1)) {

           // $minpontos2 = $pontos;

        }

        } else{
	
	
	}
    };

     

    $classificafurious[$count] = new stdClass();

    $classificafurious[$count]->totpontos = $totpontos - $minpontos1;// - $minpontos2;

    $classificafurious[$count]->id_piloto = $pilotoequipe->id_piloto;

    $classificafurious[$count]->piloto = $pilotoequipe->name_piloto;

    $classificafurious[$count]->id_equipe = $pilotoequipe->id_equipe;

    $classificafurious[$count]->equipe = $pilotoequipe->equipe;

    $classificafurious[$count]->bonusmelhorvolta = $bonusmelhorvolta;

    $classificafurious[$count]->bonusmelhorvolta25 = $melhor;

    $classificafurious[$count]->grupo = $pilotoequipe->grupo;

    $classificafurious[$count]->deducao = $deducao;

    $classificafurious[$count]->descarte1 = $minpontos1;

    $classificafurious[$count]->descarte2 = $minpontos2;



    $classificaeqfurious[$count] = new stdClass();

    $classificaeqfurious[$count]->totpontos = $totpontoseq;

    $classificaeqfurious[$count]->id_piloto = $pilotoequipe->id_piloto;

    $classificaeqfurious[$count]->piloto = $pilotoequipe->name_piloto;

    $classificaeqfurious[$count]->id_equipe = $pilotoequipe->id_equipe;

    $classificaeqfurious[$count]->equipe = $pilotoequipe->equipe;

    $classificaeqfurious[$count]->bonusmelhorvolta = $bonusmelhorvoltaeq;

    $classificaeqfurious[$count]->bonusmelhorvolta25 = $melhoreq;

    $classificaeqfurious[$count]->grupo = $pilotoequipe->grupo;

    $classificaeqfurious[$count]->deducao = $deducaoeq;

    $classificaeqfurious[$count]->descarte1 = $minpontos1;

    $classificaeqfurious[$count]->descarte2 = $minpontos2;



    $count++;

}





function sortByOrderingfurious($obj1, $obj2)

{

    return $obj1->totpontos - $obj2->totpontos;

}



usort($classificafurious, 'sortByOrderingfurious');

arsort($classificafurious);

//print_r($classifica);

$countasc = 1;

$cor = '';

$corded = '';

foreach ($classificafurious as $classificaasc) {



    echo '<tr>';

    echo '<td>' . $countasc . '</td>';

    echo '<td>' . $classificaasc->piloto . '</td>';

    echo '<td>' . substr($classificaasc->equipe,0,9) . '</td>';

    foreach ($this->etapasfurious as $etapas) {

        $bonusml = $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;

        $ptetapa = CompetitionsModelCompetitions::getPtetapa($etapas->etapa, $classificaasc->id_piloto);

        if (empty($ptetapa)) {

            echo '<td>0</td>';

        } else {

            if ($ptetapa[0]->pontos == 30) {

                $cor = 'verde';

            } elseif ($ptetapa[0]->pontos < 30 && $ptetapa[0]->pontos >= 21) {

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



echo '<h1>Classifica&ccedil;&atilde;o por Equipes Fast</h1>';

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

    

   

    foreach ($classificaeq as $classificaasc) {

      

        if ($classificaasc->id_equipe == $equipepiloto->id_team) {



            $totpontoseq = $totpontoseq + $classificaasc->totpontos ;

            $melhoreseq = $melhoreseq + $classificaasc->bonusmelhorvolta + $classificaasc->bonusmelhorvolta25;

            

             

        }

    }

    

   

    $classificaeqt[$counteq] = new stdClass();

    $classificaeqt[$counteq]->totpontoseq = $totpontoseq;

    $classificaeqt[$counteq]->id_equipe = $equipepiloto->id_team;

    $classificaeqt[$counteq]->equipe = $equipepiloto->equipe;

    $classificaeqt[$counteq]->melhoreseq = $melhoreseq;

    $counteq++;

}



$countequipe = 1;



foreach ($classificaeqt as $classificaeqasc) {



  

   



    $classificaequipe[$countequipe] = new stdClass();

    

    $classificaequipe[$countequipe]->totpontoseq = $classificaeqasc->totpontoseq ;

    $classificaequipe[$countequipe]->id_equipe = $classificaeqasc->id_equipe;

    $classificaequipe[$countequipe]->equipe = $classificaeqasc->equipe;

    $classificaequipe[$countequipe]->melhoreseq = $classificaeqasc->melhoreseq;

  

    $countequipe++;

}



$countasc = 1;



function calculaMinPontos($qtdPiloto, $equipe, $etapa){

    $minpontos = 0;

    if ($qtdPiloto == 3) {

        $minpontos = CompetitionsModelCompetitions::getPontosMinEquipeFast($equipe, $etapa);

    }

    return $minpontos[0]->minpontoequipe;

} 



foreach ($classificaequipe as $classificaeqasc) {

    $totalpontos = [];

    foreach ($this->etapas as $etapas) {

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipeFast($classificaeqasc->id_equipe, $etapas->etapa);

        $pontoequipeetapa =  $ptetapa[0]->pontoequipe - calculaMinPontos($ptetapa[0]->qtde_pilot, $classificaeqasc->id_equipe, $etapas->etapa);

        array_push($totalpontos, $pontoequipeetapa);

    }

    $classificaeqasc->totpontoseq = array_sum($totalpontos) + $classificaeqasc->melhoreseq;

}



function sortByOrderingEq($obj1, $obj2)

{

    return $obj1->totpontoseq - $obj2->totpontoseq;

}



usort($classificaequipe, 'sortByOrderingEq');

arsort($classificaequipe);



foreach ($classificaequipe as $classificaeqasc) {

    echo '<tr>';

    echo '<td>' . $countasc . '</td>';

    echo '<td>' . $classificaeqasc->equipe . '</td>';

    $totalpontos = [];

    foreach ($this->etapas as $etapas) {

        

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipeFast($classificaeqasc->id_equipe, $etapas->etapa);

        $minpontos1 = 0;

        if (empty($ptetapa)) {

            echo '<td>0</td>';

        } else {

            $pontoequipeetapa =  $ptetapa[0]->pontoequipe - calculaMinPontos($ptetapa[0]->qtde_pilot, $classificaeqasc->id_equipe, $etapas->etapa);

            array_push($totalpontos, $pontoequipeetapa);

            

            echo '<td>' . $pontoequipeetapa . '</td>';

           

        }

        

    }

    

    if ($classificaeqasc->melhoreseq == 0) {

        $corded = 'vermelho';

    } else {

        $corded = 'transp';

    }

    echo '<td class="' . $corded . '">' . str_replace('.', ',', $classificaeqasc->melhoreseq) . '</td>';



    echo '<td class="azul">' . str_replace('.', ',', array_sum($totalpontos)+ $classificaeqasc->melhoreseq ) . '</td></tr>';

    

    $countasc++;



}



echo '</table>';

echo '</div>';







//////////////////////////////////////////////////////////////



echo '<h1>Classifica&ccedil;&atilde;o por Equipes - Furious</h1>';



echo '<table>';

echo '<tr>';

echo '<th class="rotate"><div><span>Posi&ccedil;&atilde;o</span></div></th>';

echo '<th>Equipes</th>';

$classificaefurious = array();

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





echo '<th>Total</th>';



echo '</tr>';



echo '<tr class="cinza">';



echo '<td colspan=2></td>';

$countetapas = 0;

foreach ($this->etapasfurious as $etapas) {

    $countetapas = $countetapas + 1;

    echo '<td>' . $countetapas . '&ordm;</td>';

}

echo '<td>VR</td>';

echo '<td>PTS</td>';



echo '</tr>';





echo '<tr>';



foreach ($this->equipepilotofurious as $equipepiloto) {

    

    $totpontoseq = 0;



    $melhoreseq = 0;

  

    foreach ($classificaeqfurious as  $classificaasc) {

       

        if ( $classificaasc->id_equipe == $equipepiloto->id_team) {

            $totpontoseq = $totpontoseq +  $classificaasc->totpontos;           

            $melhoreseq = $melhoreseq +  $classificaasc->bonusmelhorvolta +  $classificaasc->bonusmelhorvolta25;

        }

        

    }

   

    

    $classificaeqtfurious[$counteq] = new stdClass();

    $classificaeqtfurious[$counteq]->totpontoseq = $totpontoseq;

    $classificaeqtfurious[$counteq]->id_equipe = $equipepiloto->id_team;

    $classificaeqtfurious[$counteq]->equipe = $equipepiloto->equipe;

    $classificaeqtfurious[$counteq]->melhoreseq = $melhoreseq;



    $counteq++;

   

}







$countequipe = 1;

foreach ($classificaeqtfurious as  $classificaasc) {



  





    

   

    $classificaeqfuri[$countequipe] = new stdClass();

    $classificaeqfuri[$countequipe]->totpontoseq = $classificaasc->totpontoseq;

    $classificaeqfuri[$countequipe]->id_equipe =  $classificaasc->id_equipe;

    $classificaeqfuri[$countequipe]->equipe =  $classificaasc->equipe;

    $classificaeqfuri[$countequipe]->melhoreseq =  $classificaasc->melhoreseq;

    

    $countequipe++;

}



function calculaMinPontosFurious($qtdPiloto, $equipe, $etapa){

    $minpontos = 0;

    if ($qtdPiloto == 3) {

        $minpontos = CompetitionsModelCompetitions::getMinPontosEquipefurious($equipe, $etapa);

    }

    return $minpontos[0]->minpontoequipe;

} 



foreach ($classificaeqfuri as $classificaasc) {

    $totalpontos = [];

    foreach ($this->etapasfurious as $etapas) {

        $ptetapa = CompetitionsModelCompetitions::getPontosEquipefurious($classificaasc->id_equipe, $etapas->etapa);

        $pontoequipeetapa =  $ptetapa[0]->pontoequipe - calculaMinPontosFurious($ptetapa[0]->qtde_pilot, $classificaasc->id_equipe, $etapas->etapa);

        array_push($totalpontos, $pontoequipeetapa);

    }

    $classificaasc->totpontoseq = array_sum($totalpontos) + $classificaasc->melhoreseq;

}





usort($classificaeqfuri, 'sortByOrderingEq');

arsort($classificaeqfuri);



$countasc = 1;



foreach ( $classificaeqfuri as $classificaasc) {

    echo '<tr>';

    echo '<td>' . $countasc . '</td>';

    echo '<td>' . $classificaasc->equipe . '</td>';



    

    $ptetapa = 0 ;

    foreach ($this->etapasfurious as $etapas) {



        $ptetapa = CompetitionsModelCompetitions::getPontosEquipefurious($classificaasc->id_equipe, $etapas->etapa);



        if (empty($ptetapa)) {

            echo '<td>0</td>';

        } else {

            $pontoequipeetapa =  $ptetapa[0]->pontoequipe - calculaMinPontosfurious($ptetapa[0]->qtde_pilot, $classificaasc->id_equipe, $etapas->etapa);

            array_push($totalpontos, $pontoequipeetapa);

            

            echo '<td>' . $pontoequipeetapa . '</td>';

        }



    }







    if ($classificaasc->melhoreseq == 0) {

        $corded = 'vermelho';

    } else {

        $corded = 'transp';

    }

    echo '<td class="' . $corded . '">' . str_replace('.', ',', $classificaasc->melhoreseq) . '</td>';



    echo '<td class="azul">' . $classificaasc->totpontoseq . '</td></tr>';

    

    $countasc++;



}

echo '</table>';



echo '</div>';

////////////////////////////////////////////////////



?>