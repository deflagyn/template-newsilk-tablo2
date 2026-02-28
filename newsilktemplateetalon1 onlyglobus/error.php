<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

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
  <body class="site tpl-brics-freight error-page">
    <main class="site-main" role="main">
      <div class="container">
        <div class="card error-card">
          <div class="section-kicker"><?php echo Text::_('TPL_BRICS_FREIGHT_ERROR_KICKER'); ?></div>
          <h1><?php echo htmlspecialchars($this->error->getCode(), ENT_QUOTES, 'UTF-8'); ?></h1>
          <p class="section-lead"><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
          <div class="actions" style="margin-top: 16px">
            <a class="btn btn-primary" href="<?php echo Route::_('index.php'); ?>">
              <?php echo Text::_('TPL_BRICS_FREIGHT_GO_HOME'); ?>
            </a>
            <a class="btn" href="javascript:history.back()">
              <?php echo Text::_('TPL_BRICS_FREIGHT_GO_BACK'); ?>
            </a>
          </div>
          <p class="muted" style="margin-top: 14px">
            <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>
          </p>
        </div>
      </div>
    </main>
  </body>
</html>

