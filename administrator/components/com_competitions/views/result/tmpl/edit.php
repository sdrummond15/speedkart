<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_competitions
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$assoc = JLanguageAssociations::isEnabled();

?>
<script type="text/javascript">
    Joomla.submitbutton = function (task) {
        if (task == 'result.cancel' || document.formvalidator.isValid(document.id('result-form'))) {
            Joomla.submitform(task, document.getElementById('result-form'));
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_competitions&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="result-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_COMPETITIONS_NEW_RESULT', true) : JText::_('COM_COMPETITIONS_EDIT_RESULT', true)); ?>
        <div class="row-fluid">
            <div class="span9">
                <div class="row-fluid form-horizontal-desktop">
                    <div class="span6">
                        <?php echo $this->form->renderField('id_pilot'); ?>
                        <?php echo $this->form->renderField('id_team'); ?>
                        <?php echo $this->form->renderField('position_grid'); ?>
                        <?php echo $this->form->renderField('position'); ?>
                        <?php echo $this->form->renderField('best_lap'); ?>
                        <?php echo $this->form->renderField('position_best_lap'); ?>
                        <?php echo $this->form->renderField('turns'); ?>
                        <?php echo $this->form->renderField('points'); ?>
                        <?php echo $this->form->renderField('deductions'); ?>
                        <?php echo $this->form->renderField('desc_deductions'); ?>
                        <?php echo $this->form->renderField('full_time'); ?>
                        <?php echo $this->form->renderField('difference_time'); ?>
                        <?php echo $this->form->renderField('ballast_number'); ?>
                        <?php echo $this->form->renderField('pilot_weight'); ?>
                        <?php echo $this->form->renderField('id_stage'); ?>
                    </div>
                </div>
            </div>
            <div class="span3">
                <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
        <div class="row-fluid form-horizontal-desktop">
            <div class="span6">
                <?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
            </div>
            <div class="span6">
                <?php echo JLayoutHelper::render('joomla.edit.metadata', $this); ?>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>



        <?php if ($assoc) : ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'associations', JText::_('JGLOBAL_FIELDSET_ASSOCIATIONS', true)); ?>
            <?php echo $this->loadTemplate('associations'); ?>
            <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

    <input type="hidden" name="task" value=""/>
    <?php echo JHtml::_('form.token'); ?>
</form>
