<?php
    $document = JFactory::getDocument();
    $document->addScriptDeclaration('var baseUrl = \'' . JURI::base() . '\'');
    $dados = $_POST;
    if (!empty($dados)) {
        $nome = isset($dados["nome"]) && !empty($dados["nome"]) ? $dados["nome"] : "";
        $telefone = isset($dados["telefone"]) && !empty($dados["telefone"]) ? $dados["telefone"] : "";
        $email = isset($dados["email"]) && !empty($dados["email"]) ? $dados["email"] : "";
        $nomecamisa = isset($dados["nomecamisa"]) && !empty($dados["nomecamisa"]) ? $dados["nomecamisa"] : "";
        $dtniver = isset($dados["dtniver"]) && !empty($dados["dtniver"]) ? $dados["dtniver"] : "";
        $tamanho = isset($dados["tamanho"]) && !empty($dados["tamanho"]) ? $dados["tamanho"] : "";
        $parcelas = isset($dados["parcelas"]) && !empty($dados["parcelas"]) ? $dados["parcelas"] : "";
        $extra = isset($dados["extra"]) && !empty($dados["extra"]) ? $dados["extra"] : "";
        $infantil = isset($dados["infantil"]) && !empty($dados["infantil"]) ? $dados["infantil"] : "";
        $obs = isset($dados["obs"]) && !empty($dados["obs"]) ? $dados["obs"] : "";
        $corrida = isset($dados["corrida"]) && !empty($dados["corrida"]) ? $dados["corrida"] : "";
        
        $sucesso = $dados["sucesso"];
        $erro = $dados["erro"];
        $app = JFactory::getApplication();
        $mailfrom = $app->get("mailfrom");
        $fromname = $app->get("fromname");
        $sitename = $app->get("sitename");

        $subject = "Inscrição SpeedKart 2024";

        $body = "<h2>" . $subject . "</h2>";
        $body .= "<p><b>Nome:</b> $nome <br>";
        $body .= "<b>E-mail:</b> $email <br>";
        $body .= "<b>Telefone:</b> $telefone <br>";
        $body .= "<b>Nome Camisa:</b> $nomecamisa <br>";
        $body .= "<b>Data Aniversário:</b> $dtniver <br>";
        $body .= "<b>Tamanho Camisa:</b> $tamanho <br>";
        $body .= "<b>Quantidade de Parcelas:</b> $parcelas <br>";
        $body .= "<b>Camisa Extra:</b> $extra <br>";
        $body .= "<b>Camisa Infantil:</b> $infantil <br>";
        $body .= "<b>Observações:</b> $obs </p>";
        $body .= "<b>Participa de Outro Campeonato?</b> $corrida </p>";

        $mail = JFactory::getMailer();
        $mail->addRecipient($mailfrom);
        $mail->setSender([$mailfrom, $fromname]);
	$mail->addRecipient($email);
        $mail->isHtml();
        $mail->setSubject($subject);
        $mail->setBody($body);
        $sent = $mail->Send();
        echo '<div class="enviado-overlay"></div>' .
            '<div class="enviado animated fadeIn">' .
            '<div class="fechar"><i class="fa fa-times" aria-hidden="true"></i></div>' .
            "<h1>Obrigado por<br>efetuar sua inscrição!</h1>" .
            '<div class="linha"></div>' .
            "</div>";
    }
?>

<section id="subscribe">
    <div class="subscribe">
        <h2>Preencha o formulário e participe do SpeedKart 2024!</h2>
        <div id="retornoHTML">
            <form id="form-subscribe" method="post" enctype="multipart/form-data">
            <div class="control-group">
                    <div class="controls">
                    <label for="campenato_valor">Valor da Inscrição: R$ 450,00</label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label for="tamanho">Quantidade de Parcelas:</label>
                        <select name="parcelas" id="parcelas">
                            <option value="à vista">À Vista</option>
                            <option value="2x">2 Parcelas</option>
                            <option value="3x">3 Parcelas</option>
                            <option value="4x">4 Parcelas</option>
                            <option value="5x">5 Parcelas</option>
                        </select>
                    </div>
                </div>
                <br />
                <br />
                <div class="control-group">
                    <div class="controls">
                        <input id="nome" name="nome" type="text" placeholder="Nome" required>
                    </div>
                </div>
                <div class="control-group divider">
                    <div class="controls">
                        <input id="telefone" name="telefone" type="tel" placeholder="Telefone" required>
                    </div>
                </div>
                <div class="control-group divider right">
                    <div class="controls">
                        <input id="email" name="email" type="email" placeholder="E-mail" required>
                    </div>
                </div>
                <div class="control-group divider">
                    <div class="controls">
                        <input id="nomecamisa" name="nomecamisa" type="text" placeholder="Nome na Camisa" required>
                    </div>
                </div>
                <div class="control-group divider right">
                    <div class="controls">
                        <input id="dtniver" name="dtniver" type="text" placeholder="Data de Aniversário" required>
                    </div>
                </div>
                <div class="control-group divider3">
                    <div class="controls">
                        <label for="tamanho">Escolha o tamanho:</label>
                        <select name="tamanho" id="tamanho">
                            <option value="P">P</option>
                            <option value="M">M</option>
                            <option value="G">G</option>
                            <option value="GG">GG</option>
			    <option value="XG">XG</option>
			    <option value="XXG">XXG</option>

                        </select>
                    </div>
                </div>
                <div class="control-group divider3">
                    <div class="controls inline">
                        <label>Camisa Extra?</label>
                        <div class="radio-inline">
                            <input type="radio" id="extraS" class="extra" name="extra" value="S" />
                            <label for="extraS" class="btn-extra"><span>Sim</span></label>
                        </div>
                        <div class="radio-inline">
                            <input type="radio" id="extraN" class="extra" name="extra" value="N" checked />
                            <label for="extraN" class="btn-extra"><span>Não</span></label>
                        </div>
                    </div>
                </div>
                <div class="control-group divider3 right">
                    <div class="controls inline">
                        <label>Camisa Infantil?</label>
                        <div class="radio-inline">
                            <input type="radio" id="infantilS" class="infantil" name="infantil" value="S" />
                            <label for="infantilS" class="btn-infantil"><span>Sim</span></label>
                        </div>
                        <div class="radio-inline">
                            <input type="radio" id="infantilN" class="infantil" name="infantil" value="N" checked />
                            <label for="infantilN" class="btn-infantil"><span>Não</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <textarea placeholder="Observação. Colocar quantidade de camisas extras e infantis com os respectivos tamanhos." name="obs"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label for="corrida">Participa de Outro Campeonato?</label>
                        <div class="radio-inline">
                            <input type="radio" id="corridaS" class="corrida" name="corrida" value="S" />
                            <label for="corridaS" class="corrida-extra"><span>Sim</span></label>
                        </div>
                        <div class="radio-inline">
                            <input type="radio" id="corridaN" class="corrida" name="corrida" value="N" checked />
                            <label for="corridaN" class="corrida-extra"><span>Não</span></label>
                        </div>
                    </div>
                </div>
                <input id="sucesso" type="hidden" name="sucesso" value="<?php echo $sucesso; ?>" />
                <input id="erro" type="hidden" name="erro" value="<?php echo $erro; ?>" />

                <button type="submit" id="enviar" class="btn btn-default">
                    <?= !empty($enviar) ? $enviar : "Enviar" ?>
                </button>
                <div class="loading">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= JURI::base(true) ?>/modules/mod_campaign_form/assets/js/jquery.mask.min.js">
</script>
<script type="text/javascript" src="<?= JURI::base(true) ?>/modules/mod_campaign_form/assets/js/scripts.js"></script>