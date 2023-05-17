<div class="grids">
    <?php
    $position = '';
    $count = 1;
    echo '<div class="local">';
    foreach ($this->grids as $grid) {
        echo '<div class="img_local"><img src="' . $grid->img_circuito . '"></div>';
        echo '<h1>' . $grid->nome_etapa . ' - ' . $grid->ano . '</h1>';
        echo '<h2>' . $grid->kartodromo . '</h2>';
        $data = strtotime($grid->data);
        $data = date('d/m/Y', $data);
        echo '<h2>' . $data . ' - ' . $grid->hora . '</h2>';
        echo '<h3>Circuito ' . $grid->circuito . '</h3>';
        echo '<div class="voltar"><a href="javascript:history.go(-1)"><<< Voltar</a></div>';
        $position = $grid->positions;
    }
    echo '</div>';

    $positions = explode(',', $position);

    if (!empty($positions)) {
        echo '<div class="gridmontado">';
        foreach ($positions as $position) {
            $imageDefault = JURI::base() . 'images/pilotos/default.jpg';

            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('id AS id, name AS piloto, photo AS foto');
            $query->from('#__pilots');
            $query->where('id = ' . $position);
            $db->setQuery($query);
            $piloto = $db->loadObjectList();

            echo '<div class="posicao">';
            echo '<div class="colocacao">';
            echo '<p>' . $count . 'º Lugar</p>';
            echo '</div>';
            echo '<div class="pilotopos">';
            if (!empty($piloto[0]->foto)) {
                echo '<div class="photo" style="background-image: url(' . JURI::base() . $piloto[0]->foto . ')"></div>';
            } else {
                echo '<div class="photo" style="background-image: url(' . $imageDefault . ')"></div>';
            }
            echo '<p><a href="' . JRoute::_('index.php?option=com_pilots&view=pilot&id_piloto=' . $piloto[0]->id) . '" >' . $piloto[0]->piloto . '</a></p>';
            echo '</div>';
            echo '</div>';

            $count++;
        }


        echo '</div>';
    }
    ?>
</div>
