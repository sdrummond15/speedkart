<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class CalendarControllerCalendar extends JControllerForm
{

    public function contract_data()
    {

        $mainframe = JFactory::getApplication();

        $db = JFactory::getDbo();

        try {

            $db->transactionStart();

            //Valida Campos
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                JFactory::getApplication()->enqueueMessage('Código de Imóvel Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['id_owner']) || empty($_POST['id_owner'])) {
                JFactory::getApplication()->enqueueMessage('Locatário Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['finality']) || empty($_POST['finality'])) {
                JFactory::getApplication()->enqueueMessage('Finalidade Inválida', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['light']) || empty($_POST['light'])) {
                JFactory::getApplication()->enqueueMessage('Leitura de Energia Inválida', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['water']) || empty($_POST['water'])) {
                JFactory::getApplication()->enqueueMessage('Leitura da Água Inválida', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['syndic']) || empty($_POST['syndic'])) {
                JFactory::getApplication()->enqueueMessage('Síndico Inválida', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['syndic_phone']) || empty($_POST['syndic_phone'])) {
                JFactory::getApplication()->enqueueMessage('Telefone do Síndico Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['syndic_email']) || empty($_POST['syndic_email'])) {
                JFactory::getApplication()->enqueueMessage('E-mail do Síndico Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['fire_insurance']) || empty($_POST['fire_insurance'])) {
                JFactory::getApplication()->enqueueMessage('Seguro Incêndio Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            if (!isset($_POST['surety_bond']) || empty($_POST['surety_bond'])) {
                JFactory::getApplication()->enqueueMessage('Seguro Fiança Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            $user = JFactory::getUser();
            $id_user = $user->get('id');
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__owners');
            $query->where('created_by = ' . $id_user);
            $db->setQuery($query);
            $resultOwner = $db->loadObjectList();

            if (empty($resultOwner)) {
                JFactory::getApplication()->enqueueMessage('Locatário Inválido', 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage'));
                return false;
            }

            $id = $_POST['id'];
            $id_owner = $_POST['id_owner'];
            $finality = trim($_POST['finality']);
            $light = trim($_POST['light']);
            $water = trim($_POST['water']);
            $syndic = trim($_POST['syndic']);
            $syndic_phone = trim($_POST['syndic_phone']);
            $syndic_email = trim($_POST['syndic_email']);
            $fire_insurance = trim($_POST['fire_insurance']);
            if (!empty($fire_insurance))
                $fire_insurance = $this->convertMoeda($fire_insurance);

            $surety_bond = trim($_POST['surety_bond']);
            if (!empty($surety_bond))
                $surety_bond = $this->convertMoeda($surety_bond);

            $date = new DateTime("now", new DateTimeZone('America/Sao_Paulo'));
            $date_contract = $date->format('Y-m-d H:i:s');

            PHP_email::email_confirma_contrato($user, $id);
            PHP_email::email_novo_contrato($user, $resultOwner[0], $id);

            $query = $db->getQuery(true);

            $columns = array(
                'id_owner',
                'id_enterprise',
                'finality',
                'reading_light',
                'reading_water',
                'syndic',
                'syndic_phone',
                'syndic_email',
                'fire_insurance',
                'surety_bond',
                'location_date',
                'published',
                'created',
                'created_by'
            );

            // Insert values.
            $values = array(
                $db->quote($id_owner),
                $db->quote($id),
                $db->quote($finality),
                $db->quote($light),
                $db->quote($water),
                $db->quote($syndic),
                $db->quote($syndic_phone),
                $db->quote($syndic_email),
                $db->quote($fire_insurance),
                $db->quote($surety_bond),
                $db->quote($date_contract),
                $db->quote(1),
                $db->quote($date_contract),
                $db->quote($id_user)
            );

            // Prepare the insert query.
            $query
                ->insert($db->quoteName('#__contracts'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));

            // Set the query using our newly populated query object and execute it.
            $db->setQuery($query);

            $result = $db->execute();

            $db->transactionCommit();

        } catch (Exception $e) {
            // catch any database errors.
            $db->transactionRollback();
            JErrorPage::render($e);
        }

        JFactory::getApplication()->enqueueMessage('Contrato Solicitado com Sucesso. Aguarde nosso retorno.', 'success');
        $mainframe->redirect(JRoute::_('index.php?option=com_calendar&view=stage&id='.$id));

    }

    public function convertMoeda($valor)
    {
        $preco = substr($valor, 3);
        $preco = str_replace('.', '', $preco);
        $preco = str_replace(',', '.', $preco);
        $preco = number_format($preco, 2, '.', '');
        return $preco;
    }

}

class PHP_email extends PHPMailer {

    function email_confirma_contrato($user, $id) {

        $app = JFactory::getApplication();
        $mailfrom = $user->get('email');
        $fromname = 'Contrato - COMPRAReALUGAR';
        $sitename = $app->getCfg('sitename');

        $mail = JFactory::getMailer();
        $mail->addRecipient($mailfrom);
        $mail->setSender(array($mailfrom, $fromname));
        $mail->IsHTML();
        $mail->setSubject("Contrato Imóvel COMPRAReALUGAR");
        $mail->setBody(
            '<html>'
            . '<body>'
            . '<p>Seu pedido de contrato foi enviado com sucesso.</p>'
            . '<p>Aguarde nosso retorno.</p>'
            . '<p><a href="'.JURI::base().'index.php/imoveis/stage/'.$id.'" target="_blank">Clique aqui e veja seu imóvel.</a></p>'
            . '</body>'
            . '</html>');

        $sent = $mail->Send();
    }

    function email_novo_contrato($user, $owner, $id) {

        $config = JFactory::getConfig();

        $app = JFactory::getApplication();
        $mailfrom = $config->get('mailfrom');
        $fromname = 'Contrato - COMPRAReALUGAR';
        $sitename = $app->getCfg('sitename');

        $mail = JFactory::getMailer();
        $mail->addRecipient($mailfrom);
        $mail->setSender(array($mailfrom, $fromname));
        $mail->IsHTML();
        $mail->setSubject("Contrato Imóvel COMPRAReALUGAR");
        $mail->setBody(
            '<html>'
            . '<body>'
            . '<p>O usuário ' . $user->get('name') . ' acaba de solicitar um contrato para o cliente ' . $owner->name . ' referente ao imóvel de código ' .str_pad($id, 8, 0, STR_PAD_LEFT). '.</p>'
            . '<p>Acesse o <a href="'.JURI::base().'administrator" target="_blank">Painel Adminitrativo</a> para gerar o contrato do cliente.</p>'
            . '</body>'
            . '</html>');

        $sent = $mail->Send();
    }

}
