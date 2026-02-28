<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.tpl_brics_freight
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;

/**
 * Expected variables from mod_menu:
 * - array  $list
 * - int    $active_id
 * - array  $path
 * - object $params
 */

$menuClass = trim('brics-menu ' . ($params->get('class_sfx') ?? ''));

echo '<nav class="brics-nav" aria-label="Main">';
echo '<ul class="' . htmlspecialchars($menuClass, ENT_QUOTES, 'UTF-8') . '">';

foreach ($list as $i => $item) {
  $classes = [];
  $classes[] = 'item-' . (int) $item->id;

  if (!empty($item->deeper)) {
    $classes[] = 'has-children';
  }

  if ((int) $item->id === (int) $active_id) {
    $classes[] = 'is-current';
  }

  if (!empty($path) && in_array((int) $item->id, $path, true)) {
    $classes[] = 'is-active';
  }

  if (!empty($item->class)) {
    $classes[] = $item->class;
  }

  echo '<li class="' . htmlspecialchars(implode(' ', $classes), ENT_QUOTES, 'UTF-8') . '">';

  $title = $item->title ?? '';
  $title = OutputFilter::ampReplace($title);

  $link = $item->flink ?? ($item->link ?? '#');
  $linkAttribs = [];
  $linkAttribs[] = 'href="' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '"';
  $linkAttribs[] = 'class="brics-menu-link"';

  if (!empty($item->anchor_title)) {
    $linkAttribs[] = 'title="' . htmlspecialchars($item->anchor_title, ENT_QUOTES, 'UTF-8') . '"';
  }

  if (!empty($item->anchor_css)) {
    $linkAttribs[] = 'class="brics-menu-link ' . htmlspecialchars($item->anchor_css, ENT_QUOTES, 'UTF-8') . '"';
  }

  if (!empty($item->browserNav)) {
    if ((int) $item->browserNav === 1) {
      $linkAttribs[] = 'target="_blank" rel="noopener noreferrer"';
    } elseif ((int) $item->browserNav === 2) {
      $linkAttribs[] = 'target="_parent"';
    }
  }

  echo '<a ' . implode(' ', $linkAttribs) . '>' . $title . '</a>';

  if (!empty($item->deeper)) {
    echo '<ul class="brics-submenu" aria-label="Submenu">';
  } elseif (!empty($item->shallower)) {
    echo '</li>';
    echo str_repeat('</ul></li>', (int) $item->level_diff);
  } else {
    echo '</li>';
  }
}

echo '</ul>';
echo '</nav>';

