<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

// Wrap core template for stability and style it via CSS.
echo '<div class="brics-content brics-featured">';

$core = JPATH_ROOT . '/components/com_content/tmpl/featured/default.php';
if (is_file($core)) {
  require $core;
}

echo '</div>';

