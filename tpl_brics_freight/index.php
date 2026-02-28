<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 *
 * @copyright   (C) 2026
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
$this->addStyleSheet('media/templates/site/tpl_brics_freight/css/template.css');
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app  = Factory::getApplication();
$menu = $app->getMenu();

$active = $menu->getActive();
$isHome = $active && !empty($active->home);

// Load Bootstrap framework only.
HTMLHelper::_('bootstrap.framework');

$params = $app->getTemplate(true)->params;

$brandText   = (string) $params->get('brand_text', 'NEW SILK ROAD BRICS+');
$enableGlobe = (bool) $params->get('enable_globe', 0);

$siteName = (string) $app->get('sitename');
$homeUrl  = Route::_('index.php');

?>
<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
  </head>
  <body class="site tpl-brics-freight">
    <a class="skip-link" href="#brics-main">
      <?php echo Text::_('TPL_BRICS_FREIGHT_SKIP_TO_CONTENT'); ?>
    </a>

    <?php if ($this->countModules('debug')) : ?>
      <jdoc:include type="modules" name="debug" style="none" />
    <?php endif; ?>

    <?php if ($enableGlobe && $isHome) : ?>
      <div class="globe-bg" aria-hidden="true">
        <div id="brics-globe-bg"></div>
      </div>
      <div class="grid-overlay" aria-hidden="true"></div>
    <?php endif; ?>

    <?php if ($this->countModules('topbar')) : ?>
      <div class="top-strip">
        <div class="container">
          <jdoc:include type="modules" name="topbar" style="none" />
        </div>
      </div>
    <?php endif; ?>

    <header class="site-header" role="banner">
      <div class="container nav">
        <div class="brand">
          <a class="brand-link" href="<?php echo $homeUrl; ?>" aria-label="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($brandText, ENT_QUOTES, 'UTF-8'); ?>
          </a>
        </div>

        <div class="nav-desktop">
          <?php if ($this->countModules('header-nav')) : ?>
            <jdoc:include type="modules" name="header-nav" style="none" />
          <?php endif; ?>
        </div>

        <div class="nav-right">
          <?php if ($this->countModules('languages')) : ?>
            <div class="lang-desktop">
              <jdoc:include type="modules" name="languages" style="none" />
            </div>
          <?php endif; ?>

          <?php if ($this->countModules('header-cta')) : ?>
            <div class="header-cta">
              <jdoc:include type="modules" name="header-cta" style="none" />
            </div>
          <?php endif; ?>

          <button
            class="burger"
            type="button"
            data-brics-toggle="offcanvas"
            aria-controls="brics-offcanvas"
            aria-expanded="false"
          >
            <span class="burger-lines" aria-hidden="true"></span>
            <span class="sr-only"><?php echo Text::_('TPL_BRICS_FREIGHT_OPEN_MENU'); ?></span>
          </button>
        </div>
      </div>
    </header>

    <div class="offcanvas-backdrop" data-brics-offcanvas-backdrop hidden></div>
    <aside class="offcanvas" id="brics-offcanvas" data-brics-offcanvas hidden>
      <div class="offcanvas-head">
        <div class="offcanvas-brand"><?php echo htmlspecialchars($brandText, ENT_QUOTES, 'UTF-8'); ?></div>
        <button class="offcanvas-close" type="button" data-brics-close-offcanvas>
          <span aria-hidden="true">×</span>
          <span class="sr-only"><?php echo Text::_('TPL_BRICS_FREIGHT_CLOSE_MENU'); ?></span>
        </button>
      </div>

      <?php if ($this->countModules('mobile-languages')) : ?>
        <div class="offcanvas-languages">
          <jdoc:include type="modules" name="mobile-languages" style="none" />
        </div>
      <?php elseif ($this->countModules('languages')) : ?>
        <div class="offcanvas-languages">
          <jdoc:include type="modules" name="languages" style="none" />
        </div>
      <?php endif; ?>

      <div class="offcanvas-body">
        <?php if ($this->countModules('mobile-nav')) : ?>
          <jdoc:include type="modules" name="mobile-nav" style="none" />
        <?php elseif ($this->countModules('header-nav')) : ?>
          <jdoc:include type="modules" name="header-nav" style="none" />
        <?php endif; ?>
      </div>
    </aside>

    <main id="brics-main" class="site-main" role="main">
      <div class="container">
        <?php if ($this->countModules('banner')) : ?>
          <div class="banner">
            <jdoc:include type="modules" name="banner" style="none" />
          </div>
        <?php endif; ?>

        <?php if ($this->countModules('breadcrumbs')) : ?>
          <div class="breadcrumbs">
            <jdoc:include type="modules" name="breadcrumbs" style="none" />
          </div>
        <?php endif; ?>

        <?php if ($this->countModules('main-top')) : ?>
          <div class="main-top">
            <jdoc:include type="modules" name="main-top" style="none" />
          </div>
        <?php endif; ?>

        <div class="layout">
          <?php if ($this->countModules('sidebar-left')) : ?>
            <aside class="sidebar sidebar-left">
              <jdoc:include type="modules" name="sidebar-left" style="none" />
            </aside>
          <?php endif; ?>

          <div class="content">
            <jdoc:include type="message" />
            <jdoc:include type="component" />
          </div>

          <?php if ($this->countModules('sidebar-right')) : ?>
            <aside class="sidebar sidebar-right">
              <jdoc:include type="modules" name="sidebar-right" style="none" />
            </aside>
          <?php endif; ?>
        </div>


        <?php if ($isHome) : ?>
          <section
            class="operations-console card"
            data-ops-console
            data-fleet-url="<?php echo htmlspecialchars($this->baseurl . '/media/templates/site/tpl_brics_freight/data/fleet.csv', ENT_QUOTES, 'UTF-8'); ?>"
            data-cargo-url="<?php echo htmlspecialchars($this->baseurl . '/media/templates/site/tpl_brics_freight/data/cargo.csv', ENT_QUOTES, 'UTF-8'); ?>"
          >
            <header class="ops-console__title-bar">
              <h2>CORRIDOR OPERATIONS</h2>
            </header>

            <div class="ops-console__panel">
              <h3 class="ops-console__section-title">CARGO</h3>
              <div class="ops-console__table-wrap">
                <table class="ops-console__table">
                  <thead data-ops-cargo-head></thead>
                  <tbody data-ops-cargo-body></tbody>
                </table>
              </div>
            </div>

            <div class="ops-console__panel">
              <h3 class="ops-console__section-title">FLEET</h3>
              <div class="ops-console__table-wrap">
                <table class="ops-console__table">
                  <thead data-ops-fleet-head></thead>
                  <tbody data-ops-fleet-body></tbody>
                </table>
              </div>
            </div>
          </section>
        <?php endif; ?>

        <?php if ($this->countModules('main-bottom')) : ?>
          <div class="main-bottom">
            <jdoc:include type="modules" name="main-bottom" style="none" />
          </div>
        <?php endif; ?>
      </div>
    </main>

    <footer class="site-footer" role="contentinfo">
      <div class="container">
        <?php if ($this->countModules('footer')) : ?>
          <div class="footer-grid">
            <jdoc:include type="modules" name="footer" style="none" />
          </div>
        <?php endif; ?>

        <?php if ($this->countModules('footer-bottom')) : ?>
          <div class="footer-bottom">
            <jdoc:include type="modules" name="footer-bottom" style="none" />
          </div>
        <?php else : ?>
          <div class="footer-bottom">
            <span>© <?php echo (int) date('Y'); ?> <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
        <?php endif; ?>
      </div>
    </footer>
	    <script defer src="<?php echo $this->baseurl; ?>/media/templates/site/tpl_brics_freight/js/menu.js"></script>
    <script defer src="<?php echo $this->baseurl; ?>/media/templates/site/tpl_brics_freight/js/operations-console.js"></script>
	    <script src="https://cdn.jsdelivr.net/npm/globe.gl"></script>
<script src="<?php echo $this->baseurl; ?>/media/templates/site/tpl_brics_freight/js/globe.js"></script>
  </body>
</html>

