<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/**
 * Expected variables from mod_languages:
 * - array $list
 * - object $params
 */

if (empty($list)) {
  return;
}

$active = null;
foreach ($list as $language) {
  if (!empty($language->active)) {
    $active = $language;
    break;
  }
}

$activeTitle = $active ? ($active->sef ?? $active->title_native ?? $active->title) : Text::_('JLANGUAGE');

?>
<div class="brics-lang" data-brics-lang>
  <button class="btn" type="button" data-brics-lang-button aria-haspopup="listbox" aria-expanded="false">
    <?php echo htmlspecialchars($activeTitle, ENT_QUOTES, 'UTF-8'); ?>
  </button>
  <ul class="brics-lang-list" data-brics-lang-list hidden>
    <?php foreach ($list as $language) : ?>
      <li>
        <a
          class="brics-lang-item<?php echo !empty($language->active) ? ' is-active' : ''; ?>"
          href="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>"
          lang="<?php echo htmlspecialchars($language->lang_code, ENT_QUOTES, 'UTF-8'); ?>"
          hreflang="<?php echo htmlspecialchars($language->lang_code, ENT_QUOTES, 'UTF-8'); ?>"
        >
          <?php echo htmlspecialchars($language->title_native ?: $language->title, ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

