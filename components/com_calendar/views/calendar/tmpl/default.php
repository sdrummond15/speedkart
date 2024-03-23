<div class="calendar">
    <?php
    $counttable = 0;
    $table = '';
    foreach ($this->calendar as $calendar):
        $campeonato = $calendar->campeonato;
        $ano = $calendar->ano;
        $table .= '<tr>';
        $table .= '<td>' . $calendar->etapa . '</td>';
        $table .= '<td>' . $calendar->kartodromo . '</td>';
        $dataconv = strtotime($calendar->data);
        $dia = date('d', $dataconv);
        $mes = date('n', $dataconv);
        $m = '';
        switch ($mes) {
            case 1:
                $m = 'Janeiro';
                break;
            case 2:
                $m = 'Fevereiro';
                break;
            case 3:
                $m = 'Março';
                break;
            case 4:
                $m = 'Abril';
                break;
            case 5:
                $m = 'Maio';
                break;
            case 6:
                $m = 'Junho';
                break;
            case 7:
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
        $table .= '<td>' . $dia . ' de ' . $m . '</td>';
        $table .= '<td>' . $calendar->hora . '</td>';
        $table .= '<td><a href="index.php/campeonato/todas-etapas/circuit?id_circuito=' . $calendar->id_circuito . '">' . $calendar->circuito . '</a></td>';
        // $table .= '<td>' . $calendar->grid . '</td>';
        $table .= '</tr>';

    endforeach;

    ?>
    <h1><?php echo $campeonato; ?> de Kartistas Amadores de Belo Horizonte</h1>
    <h2>Calendário para o ano de <?php echo $ano; ?></h2>
    <table>
        <thead>
        <tr>
            <td>Etapa</td>
            <td>Kartódromo</td>
            <td>Data</td>
            <td>Horário</td>
            <td>Circuito</td>
            <!-- <td>Grid</td> -->
        </tr>
        </thead>
        <tbody>
        <?php echo $table ?>
        </tbody>
    </table>
</div>
