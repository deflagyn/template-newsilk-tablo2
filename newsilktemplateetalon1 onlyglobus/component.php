<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$wa = $this->getWebAssetManager();
$wa->useStyle('tpl_brics_freight.styles');
$wa->useScript('tpl_brics_freight.menu');

HTMLHelper::_('bootstrap.framework');

?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
  </head>
  <body class="site tpl-brics-freight component-only">
    <main class="site-main" role="main">
      <div class="container">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
      </div>
    </main>
  </body>
</html>

