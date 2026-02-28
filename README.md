# template-newsilk-tablo2

Упрощённый вариант: используйте **только одну папку** `tpl_brics_freight`.

## Что делать
1. Берёте папку `tpl_brics_freight` как есть.
2. Закидываете её в ваш Git.
3. Если нужен ZIP для установки в Joomla — архивируете **содержимое этой папки** (чтобы в корне zip был `templateDetails.xml`).
4. Ставите в Joomla через **System → Install → Extensions**.

## Важно
Внутри `tpl_brics_freight` уже есть всё нужное:
- шаблонные PHP файлы;
- CSS/JS (включая `media/js/menu.js` и `media/js/operations-console.js`);
- данные табло `media/data/fleet.csv` и `media/data/cargo.csv`;
- языковые файлы и override'ы.
