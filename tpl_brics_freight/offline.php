<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$wa = $this->getWebAssetManager();
$wa->useStyle('tpl_brics_freight.styles');
$wa->useScript('tpl_brics_freight.menu');

HTMLHelper::_('bootstrap.framework');

$app      = Factory::getApplication();
$siteName = (string) $app->get('sitename');

?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
  </head>
  <body class="site tpl-brics-freight offline-page">
    <main class="site-main" role="main">
      <div class="container">
        <div class="card">
          <div class="section-kicker"><?php echo Text::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></div>
          <h1><?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></h1>
          <p class="section-lead"><?php echo Text::_('JOFFLINE_MESSAGE'); ?></p>
        </div>
      </div>
    </main>
  </body>
</html>

