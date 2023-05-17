<?php
/**
 * @copyright    Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package        Joomla.Site
 * @subpackage    mod_qualification
 * @since        1.5
 */
class modKartingsHelper
{
    public static function getKarting()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__kartings');
        $query->order('title');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();
        shuffle($rows);
        return $rows;
    }

}