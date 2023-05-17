<div class="all_stages">
    <h1><?php echo $this->stages[0]->campeonato . ' - ' . $this->stages[0]->ano; ?> </h1>

    <?php

    foreach ($this->stages as $stages):

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('p.id AS id_piloto, p.name AS piloto, r.position AS posicao');
        $query->from('#__results AS r');
        $query->join('LEFT', '#__pilots AS p ON r.id_pilot = p.id');
        $query->where('r.id_stage = ' . $stages->id_stage);
        $query->order('r.position LIMIT 5');
        $query->limit(5);

        $db->setQuery($query);

        $podio = $db->loadObjectList();

        if (!empty($podio)) :
            $data = strtotime($stages->data);
            $data = date('d/m/Y', $data);
            ?>
            <div class="single_stage">

                <h1><?php echo $stages->etapa . ' (' . $data . ')'; ?></h1>
                <h2><a href="index.php/campeonato/kartodromos"><?php echo $stages->kartodromo; ?></a></h2>
                <div class="img_kartodromo"><a href="<?php echo JRoute::_('index.php?option=com_stages&view=circuit&id_circuito=' . $stages->id_circuito); ?>" style="background-image:url('<?php echo JURI::base() . $stages->circuito; ?>');"></a></div>
                <div class="img_podio"><a href="<?php echo JRoute::_('index.php?option=com_stages&view=stage&id_stage=' . $stages->id_stage); ?>" style="background-image:url('<?php echo JURI::base() . (!empty($stages->podio)) ? $stages->podio : 'images/podium/default.jpg'; ?>');"></a></div>

                <?php
                for ($i = 0; $i <= 4; $i++) {
                    echo '<p class="qualifica">'
                        . '<a href="index.php/campeonato/pilotos/pilot?id_piloto=' . $podio[$i]->id_piloto . '">'
                        . $podio[$i]->posicao . 'º Lugar - ' . $podio[$i]->piloto
                        . '</a>'
                        . '</p>';
                }
                ?>

                <a href="<?php echo JRoute::_('index.php?option=com_stages&view=stage&id_stage=' . $stages->id_stage); ?>" class="detail">Detalhes >>></a>
            </div>
            <?php

        endif;
    endforeach;

    ?>
</div>
