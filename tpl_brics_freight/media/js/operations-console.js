(() => {
  const root = document.querySelector("[data-ops-console]");
  if (!root) return;

  const cargoHead = root.querySelector("[data-ops-cargo-head]");
  const cargoBody = root.querySelector("[data-ops-cargo-body]");
  const fleetHead = root.querySelector("[data-ops-fleet-head]");
  const fleetBody = root.querySelector("[data-ops-fleet-body]");

  const portMap = [
    ["istanbul", "TR"], ["bejaia", "DZ"], ["santos", "BR"], ["johannesburg", "ZA"], ["almaty", "KZ"],
    ["mumbai", "IN"], ["dubai", "AE"], ["moscow", "RU"], ["qingdao", "CN"], ["nantong", "CN"],
    ["koper", "SI"], ["tartous", "SY"], ["chornomorsk", "UA"], ["odessa", "UA"], ["novorossiysk", "RU"],
    ["mersin", "TR"], ["iskenderun", "TR"], ["alexandria", "EG"], ["hamburg", "DE"], ["genoa", "IT"],
    ["rotterdam", "NL"], ["antwerp", "BE"], ["singapore", "SG"], ["busan", "KR"], ["hong kong", "CN"],
    ["fujairah", "AE"], ["jebel ali", "AE"], ["karachi", "PK"], ["lagos", "NG"], ["vancouver", "CA"],
    ["new york", "US"], ["manila", "PH"], ["colombo", "LK"], ["chennai", "IN"], ["shanghai", "CN"],
    ["baku", "AZ"], ["batumi", "GE"], ["poti", "GE"], ["lisbon", "PT"], ["piraeus", "GR"], ["kandla", "IN"]
  ];

  const toFlag = (code) => (code || "")
    .toUpperCase()
    .replace(/[^A-Z]/g, "")
    .slice(0, 2)
    .split("")
    .map((ch) => String.fromCodePoint(127397 + ch.charCodeAt(0)))
    .join("") || "🌐";

  const countryCodeFor = (text) => {
    const value = String(text || "").toLowerCase();
    const normalized = value.split(" or ")[0].trim();
    const found = portMap.find(([needle]) => normalized.includes(needle));
    return found ? found[1] : "UN";
  };

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
      } else if (c === "," && !inQuotes) {
        row.push(field.trim());
        field = "";
      } else if ((c === "\n" || c === "\r") && !inQuotes) {
        if (c === "\r" && next === "\n") i += 1;
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

    const [columns = [], ...rawItems] = rows;
    const items = rawItems.map((r) => {
      const normalized = [...r];
      if (normalized.length > columns.length) {
        const head = normalized.slice(0, columns.length - 1);
        const tail = normalized.slice(columns.length - 1).join(", ");
        normalized.length = 0;
        normalized.push(...head, tail);
      }
      while (normalized.length < columns.length) normalized.push("—");

      const item = {};
      columns.forEach((col, idx) => {
        item[col] = normalized[idx] || "—";
      });
      return item;
    });

    return { columns, items };
  };

  const upper = (value) => String(value || "—").toUpperCase();

  const renderCargo = (dataset) => {
    cargoHead.innerHTML = "<tr><th>ROUTE</th><th>CARGO</th><th>QTY</th></tr>";
    cargoBody.innerHTML = dataset.items.slice(0, 8).map((item) => {
      const from = item.Loading || "—";
      const to = item.Discharging || "—";
      const route = `${toFlag(countryCodeFor(from))} ${upper(from)} → ${toFlag(countryCodeFor(to))} ${upper(to)}`;
      return `<tr><td>${route}</td><td>${upper(item.Cargo)}</td><td>${upper(item.Qty)}</td></tr>`;
    }).join("");
  };

  const renderFleet = (dataset) => {
    fleetHead.innerHTML = "<tr><th>VESSEL</th><th>TYPE</th><th>DWT</th><th>OPEN AT</th></tr>";
    fleetBody.innerHTML = dataset.items.slice(0, 8).map((item) => {
      const openAt = item["Open at"] || "—";
      const flaggedPort = `${toFlag(countryCodeFor(openAt))} ${upper(openAt)}`;
      return `<tr><td>${upper(item["Ship Name"])}</td><td>${upper(item.Type)}</td><td>${upper(item.DWT)}</td><td>${flaggedPort}</td></tr>`;
    }).join("");
  };

  Promise.all([
    fetch(root.dataset.cargoUrl).then((r) => (r.ok ? r.text() : Promise.reject(new Error("cargo")))),
    fetch(root.dataset.fleetUrl).then((r) => (r.ok ? r.text() : Promise.reject(new Error("fleet"))))
  ])
    .then(([cargoText, fleetText]) => {
      renderCargo(parseCsv(cargoText));
      renderFleet(parseCsv(fleetText));
    })
    .catch(() => {
      cargoHead.innerHTML = "<tr><th>STATUS</th></tr>";
      fleetHead.innerHTML = "<tr><th>STATUS</th></tr>";
      cargoBody.innerHTML = '<tr><td>DATA SOURCE OFFLINE</td></tr>';
      fleetBody.innerHTML = '<tr><td>DATA SOURCE OFFLINE</td></tr>';
    });
})();
