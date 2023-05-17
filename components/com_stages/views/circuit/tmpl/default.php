<div class="circuits">

    <?php
    foreach ($this->circuit as $circuit) :

        if ((empty($circuit->foto)) && ($circuit->id_karting == 1)) {
            $imgCircuito = 'images/circuitos/betim.jpg';
        } elseif ((empty($circuit->foto)) && ($circuit->id_karting == 2)) {
            $imgCircuito = 'images/circuitos/RBC.jpg';
        } else {
            $imgCircuito = $circuit->foto;
        }

        ?>
        <h1>Circuito <?php echo $circuit->circuito; ?></h1>
        <div class="circuitimg" style="background: url('<?php echo $imgCircuito; ?>')"></div>
        <div class="detalhescircuit">
            <h2><?php echo $circuit->kartodromo; ?></h2>
            <?php
            if (!empty($circuit->melhor_tempo)):
                $dataconv = strtotime($circuit->data);
                $data = date('d/m/Y', $dataconv);
                ?>
                <p>Melhor Tempo: <?php echo $circuit->melhor_tempo; ?></p>
                <p>Data do Melhor Tempo: <?php echo $data; ?></p>
                <p>Melhor Tempo feito por <a href="index.php/campeonato/pilotos/pilot?id_piloto=<?php echo $circuit->id_piloto; ?>"><?php echo $circuit->piloto; ?></a></p>
            <?php endif; ?>
            <div class="voltar"><a href="javascript:history.go(-1)"><<< Voltar</a></div>
        </div>
        <?php
    endforeach;
    ?>

</div>