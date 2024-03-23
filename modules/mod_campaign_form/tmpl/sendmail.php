<?php
define('_JEXEC', 1);

// defining the base path.
if (stristr($_SERVER['SERVER_SOFTWARE'], 'win32')) {
    define('JPATH_BASE', realpath(dirname(__FILE__) . '\..\..\..'));
} else define('JPATH_BASE', realpath(dirname(__FILE__) . '/../../..'));
define('DS', DIRECTORY_SEPARATOR);

// including the main joomla files
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

// Creating an app instance
$app = JFactory::getApplication('site');
$app->initialise();
jimport('joomla.user.user');
jimport('joomla.user.helper');

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$email_admin = $_POST['email_admin'];
$subject = $_POST['subject'];

$db = JFactory::getDbo();
    $queryApoio = $db->getQuery(true);

    $columns = array(
        'nome',
        'telefone',
        'email',
        'cpf'
    );

    $values = array(
        $db->quote($nome),
        $db->quote($telefone),
        $db->quote($email),
        $db->quote($cpf)
    );

    $queryApoio
        ->insert($db->quoteName('#__save_rolamoca'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

    $db->setQuery($queryApoio);
    $db->execute();

try {


    if (empty($email_admin)) {
        $mailfrom = $app->get('mailfrom');
    } else {
        $mailfrom = $email_admin;
    }

    $fromname = $app->get('fromname');
    $sitename = $app->get('sitename');

    if (!empty($subject)) {
        $subject = $subject;
    } else {
        $subject = 'Apoio realizado através do site ' . $app->get('sitename');
    }

    /* CORPO DO E-MAIL */
    $body ='<p>Prezadas senhoras,<br>
Solicito que a &agrave;rea destinada &agrave; implanta&ccedil;&atilde;o do Cond. Serra das Andorinhas, em Casa Branca, Brumadinho, seja adquirida pelo Estado e anexada ao parque. Ela &eacute; o &uacute;nico corredor de liga&ccedil;&atilde;o do Parque Estadual da Serra do Rola Mo&ccedil;a com a Faz. Jangada, da Vale, com a &Aacute;rea de Prote&ccedil;&atilde;o Especial de Rio Manso e com outros ambientes naturais ainda em bom estado de conserva&ccedil;&atilde;o na regi&atilde;o.
Para tanto, poder&atilde;o ser utilizados recursos do Acordo Judicial com a Vale ou da compensa&ccedil;&atilde;o miner&aacute;ria devida pela empresa.
A medida &eacute; imprescind&iacute;vel &agrave; sobreviv&ecirc;ncia do parque, amea&ccedil;ado de isolamento geogr&aacute;fico pela expans&atilde;o urbana.
Agrade&ccedil;o sua valiosa aten&ccedil;&atilde;o.</p>';

    $body .= '<p><b>Nome: </b>' . $nome . '<br>';
    $body .= '<b>Telefone: </b>' . $telefone . '<br>';
    $body .= '<b>E-mail: </b>' . $email . '<br>';
    $body .= '<b>CPF: </b>' . $cpf . '</p>';


    $mail = JFactory::getMailer();
    $mail->addRecipient(array($mailfrom, $fromname));
    $mail->addReplyTo(array($email, $nome));
    $mail->setSender(array($mailfrom, $fromname));
    $mail->isHtml();
    $mail->setSubject($subject);
    $mail->setBody($body);
    $sent = $mail->Send();

    $response['msg'] = 'Apoio efetuado com sucesso!';
    $response['class'] = 'success';
    $response['status'] = 1;
} catch (phpmailerException $e) {
    $response['class'] = 'danger';
    $response['msg'] = $e->message;
    $response['status'] = 0;
}

echo json_encode($response);
