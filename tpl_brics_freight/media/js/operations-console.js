(() => {
  const root = document.querySelector("[data-ops-console]");
  if (!root) return;

  const tabs = Array.from(root.querySelectorAll("[data-ops-tab]"));
  const head = root.querySelector("[data-ops-head]");
  const body = root.querySelector("[data-ops-body]");
  const ticker = root.querySelector("[data-ops-ticker]");

  const parseCsv = (csvText) => {
    const rows = [];
    let row = [];
    let field = "";
    let inQuotes = false;

    for (let i = 0; i < csvText.length; i += 1) {
      const c = csvText[i];
      const next = csvText[i + 1];

      if (c === '"') {
        if (inQuotes && next === '"') {
          field += '"';
          i += 1;
        } else {
          inQuotes = !inQuotes;
        }
      } else if (c === ',' && !inQuotes) {
        row.push(field.trim());
        field = "";
      } else if ((c === '\n' || c === '\r') && !inQuotes) {
        if (c === '\r' && next === '\n') i += 1;
        row.push(field.trim());
        field = "";
        if (row.some((v) => v.length > 0)) rows.push(row);
        row = [];
      } else {
        field += c;
      }
    }

    if (field.length > 0 || row.length > 0) {
      row.push(field.trim());
      if (row.some((v) => v.length > 0)) rows.push(row);
    }

    const [columns, ...items] = rows;
    return {
      columns: columns || [],
      items: items.map((r) => {
        const item = {};
        (columns || []).forEach((col, idx) => {
          item[col] = r[idx] || "—";
        });
        return item;
      })
    };
  };

  const endpointByMode = {
    fleet: root.dataset.fleetUrl,
    cargo: root.dataset.cargoUrl
  };

  const state = {
    fleet: null,
    cargo: null,
    mode: "fleet",
    tickerIndex: 0
  };

  const updateTicker = () => {
    const dataset = state[state.mode];
    if (!dataset || !dataset.items.length) {
      ticker.textContent = "Live stream offline";
      return;
    }

    const item = dataset.items[state.tickerIndex % dataset.items.length];
    const text = dataset.columns
      .slice(0, 4)
      .map((col) => `${col}: ${item[col]}`)
      .join("  •  ");

    ticker.textContent = `LIVE  ${text}`;
    state.tickerIndex += 1;
  };

  const render = () => {
    const dataset = state[state.mode];
    if (!dataset) return;

    head.innerHTML = `<tr>${dataset.columns.map((c) => `<th>${c}</th>`).join("")}</tr>`;
    body.innerHTML = dataset.items
      .slice(0, 14)
      .map((item) => `<tr>${dataset.columns.map((c) => `<td>${item[c]}</td>`).join("")}</tr>`)
      .join("");

    const first = body.querySelector("tr");
    if (first) first.classList.add("ops-console__row-pulse");

    updateTicker();
  };

  const setMode = (mode) => {
    state.mode = mode;
    tabs.forEach((tab) => {
      const active = tab.dataset.opsTab === mode;
      tab.classList.toggle("is-active", active);
      tab.setAttribute("aria-selected", active ? "true" : "false");
    });
    render();
  };

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => setMode(tab.dataset.opsTab));
  });

  Promise.all(
    Object.entries(endpointByMode).map(([mode, url]) =>
      fetch(url)
        .then((r) => {
          if (!r.ok) throw new Error(`Failed to load ${mode}`);
          return r.text();
        })
        .then((txt) => {
          state[mode] = parseCsv(txt);
        })
    )
  )
    .then(() => {
      setMode("fleet");
      window.setInterval(updateTicker, 2800);
    })
    .catch(() => {
      ticker.textContent = "Console unavailable. Data source not reachable.";
    });
})();
