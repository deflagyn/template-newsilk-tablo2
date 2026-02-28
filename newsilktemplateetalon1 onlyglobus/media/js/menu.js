(() => {
  const qs = (sel, root = document) => root.querySelector(sel);
  const qsa = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  const offcanvas = qs("[data-brics-offcanvas]");
  const backdrop = qs("[data-brics-offcanvas-backdrop]");
  const openBtn = qs('[data-brics-toggle="offcanvas"]');
  const closeBtn = qs("[data-brics-close-offcanvas]");

  if (!offcanvas || !backdrop || !openBtn) return;

  const setHidden = (el, hidden) => {
    if (!el) return;
    if (hidden) el.setAttribute("hidden", "");
    else el.removeAttribute("hidden");
  };

  const open = () => {
    setHidden(backdrop, false);
    setHidden(offcanvas, false);
    openBtn.setAttribute("aria-expanded", "true");
    document.documentElement.style.overflow = "hidden";
    const firstLink = qs("a, button", offcanvas);
    if (firstLink) firstLink.focus({ preventScroll: true });
  };

  const close = () => {
    setHidden(backdrop, true);
    setHidden(offcanvas, true);
    openBtn.setAttribute("aria-expanded", "false");
    document.documentElement.style.overflow = "";
    openBtn.focus({ preventScroll: true });
  };

  openBtn.addEventListener("click", (e) => {
    e.preventDefault();
    open();
  });

  if (closeBtn) {
    closeBtn.addEventListener("click", (e) => {
      e.preventDefault();
      close();
    });
  }

  backdrop.addEventListener("click", close);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !offcanvas.hasAttribute("hidden")) close();
  });

  // Mobile submenu behavior: keep submenus open inside offcanvas only.
  // If template override renders elements with `.brics-submenu`, we treat them as accordion groups.
  const offcanvasMenus = qsa(".brics-menu", offcanvas);
  offcanvasMenus.forEach((menu) => {
    qsa("li", menu).forEach((li) => {
      const submenu = qs(":scope > .brics-submenu", li);
      if (!submenu) return;

      // Create a toggle button if not provided by override.
      let toggle = qs(":scope > button.brics-subtoggle", li);
      if (!toggle) {
        toggle = document.createElement("button");
        toggle.type = "button";
        toggle.className = "brics-subtoggle";
        toggle.setAttribute("aria-expanded", "false");
        toggle.textContent = "+";

        const link = qs(":scope > a", li);
        if (link && link.parentElement === li) {
          link.after(toggle);
        } else {
          li.insertBefore(toggle, submenu);
        }
      }

      submenu.setAttribute("hidden", "");

      toggle.addEventListener("click", () => {
        const isOpen = !submenu.hasAttribute("hidden");
        if (isOpen) {
          submenu.setAttribute("hidden", "");
          toggle.setAttribute("aria-expanded", "false");
        } else {
          submenu.removeAttribute("hidden");
          toggle.setAttribute("aria-expanded", "true");
        }
      });
    });
  });

  // Language switcher dropdown (desktop + offcanvas).
  qsa("[data-brics-lang]").forEach((root) => {
    const btn = qs("[data-brics-lang-button]", root);
    const list = qs("[data-brics-lang-list]", root);
    if (!btn || !list) return;

    const closeLang = () => {
      list.setAttribute("hidden", "");
      btn.setAttribute("aria-expanded", "false");
    };

    const openLang = () => {
      list.removeAttribute("hidden");
      btn.setAttribute("aria-expanded", "true");
    };

    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const isOpen = !list.hasAttribute("hidden");
      if (isOpen) closeLang();
      else openLang();
    });

    document.addEventListener("click", (e) => {
      if (!root.contains(e.target)) closeLang();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeLang();
    });
  });
})();

