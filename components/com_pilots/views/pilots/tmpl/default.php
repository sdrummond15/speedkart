<div class="pilots">
    <h1>Conheça os Pilotos da Speedkart</h1>
    <?php foreach ($this->pilots as $pilot): ?>
        <div class="pilot">
        <h1><?php echo $pilot->piloto; ?></h1>
        <div class="pilotimg" style="background: url('<?php echo (!empty($pilot->foto))? JUri::base().$pilot->foto : JUri::base().'images/pilotos/default.jpg'; ?>')"></div>
        <h2><?php echo $pilot->equipe; ?></h2>
        <a href="<?php echo JRoute::_('index.php?option=com_pilots&view=pilot&id_piloto=' . $pilot->id_piloto); ?>" >Detalhes >>></a>
        </div>
    <?php endforeach; ?>
</div>