<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_competitions
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$archived = $this->state->get('filter.published') == 2 ? true : false;
$trashed = $this->state->get('filter.published') == -2 ? true : false;
$saveOrder = $listOrder == 'a.ordering';
if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_competitions&task=stages.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'competitionList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
$assoc = JLanguageAssociations::isEnabled();
?>

<script type="text/javascript">
    Joomla.orderTable = function () {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        }
        else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_competitions&view=stages'); ?>" method="post" name="adminForm" id="adminForm">

    <div id="filter-bar" class="btn-toolbar">
        <div class="filter-search btn-group pull-left">
            <label for="filter_search" class="element-invisible">
                <?php echo JText::_('COM_COMPETITIONS_FILTER_SEARCH_DESC'); ?>
            </label>
            <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('COM_COMPETITIONS_SEARCH_IN_NAME'); ?>"/>
        </div>
        <div class="btn-group pull-left">
            <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
            <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value = '';
                            this.form.submit();"><i class="icon-remove"></i></button>
        </div>
        <div class="btn-group pull-right hidden-phone">
            <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
            <?php echo $this->pagination->getLimitBox(); ?>
        </div>
        <div class="btn-group pull-right hidden-phone">
            <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
            <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
            </select>
        </div>
        <div class="btn-group pull-right">
            <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
            <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped" id="articleList">
        <thead>
        <tr>
            <th width="1%" class="nowrap center hidden-phone">
                <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
            </th>
            <th width="1%" class="hidden-phone">
                <?php echo JHtml::_('grid.checkall'); ?>
            </th>
            <th width="1%" style="min-width:55px" class="nowrap center">
                <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
            </th>
            <th width="40%" class="nowrap center">
                <?php echo JHtml::_('grid.sort', 'COM_COMPETITIONS_HEADING_STAGE', 'a.title', $listDirn, $listOrder); ?>
            </th>
            <th width="1%" class="nowrap center hidden-phone">
                <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->items as $i => $item) :
            $ordering = $listOrder == 'a.ordering';
            $canCreate = $user->authorise('core.create');
            $canEdit = $user->authorise('core.edit');
            $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
            $canEditOwn = $user->authorise('core.edit.own') && $item->created_by == $userId;
            $canChange = $user->authorise('core.edit.state') && $canCheckin;
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="order nowrap center hidden-phone">
                    <?php
                    $iconClass = '';
                    if (!$canChange) {
                        $iconClass = ' inactive';
                    } elseif (!$saveOrder) {
                        $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                    }
                    ?>
                    <span class="sortable-handler<?php echo $iconClass ?>">
                            <i class="icon-menu"></i>
                        </span>
                    <?php if ($canChange && $saveOrder) : ?>
                        <input type="text" style="display:none" name="order[]" size="5"
                               value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
                    <?php endif; ?>
                </td>
                <td class="center hidden-phone">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td class="center">
                    <div class="btn-group">
                        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'stages.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
                        <?php
                        // Create dropdown items
                        $action = $archived ? 'unarchive' : 'archive';
                        JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'stages');

                        $action = $trashed ? 'untrash' : 'trash';
                        JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'stages');

                        // Render dropdown list
                        echo JHtml::_('actionsdropdown.render', $this->escape($item->id));
                        ?>
                    </div>
                </td>
                <td class="nowrap has-context">
                    <div class="center">
                        <?php if ($item->checked_out) : ?>
                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'stages.', $canCheckin); ?>
                        <?php endif; ?>
                        <?php if ($canEdit || $canEditOwn) : ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_competitions&task=stage.edit&id=' . (int)$item->id); ?>">
                                <?php echo $this->escape($item->title); ?>
                            </a>
                        <?php else : ?>
                            <?php echo $this->escape($item->title); ?>
                        <?php endif; ?>
                    </div>
                </td>
                <td align="center hidden-phone">
                    <?php echo $item->id; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10">
                <?php echo $this->pagination->getListFooter(); ?>
            </td>
        </tr>
        </tfoot>
    </table>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>

</form>
