// media/js/globe.js
(() => {
  const el = document.getElementById('brics-globe-bg');
  if (!el || typeof Globe === 'undefined') return;

  const modeColors = {
    Sea: 'rgba(88, 166, 255, 0.95)',
    Air: 'rgba(126, 231, 135, 0.95)',
    Rail: 'rgba(242, 204, 96, 0.95)',
    Road: 'rgba(255, 123, 114, 0.95)',
  };

  const globe = new Globe(el)
    .globeImageUrl('//cdn.jsdelivr.net/npm/three-globe/example/img/earth-night.jpg')
    .bumpImageUrl('//cdn.jsdelivr.net/npm/three-globe/example/img/earth-topology.png')
    .backgroundColor('rgba(0,0,0,0)')
    .arcLabel('label')
    .arcStartLat('startLat')
    .arcStartLng('startLng')
    .arcEndLat('endLat')
    .arcEndLng('endLng')
    .arcColor('color')
    .arcDashLength(0.25)
    .arcDashGap(0.9)
    .arcDashInitialGap(() => Math.random())
    .arcDashAnimateTime(4000)
    .arcsTransitionDuration(0)
    .pointColor('color')
    .pointAltitude(0)
    .pointRadius(0.02)
    .pointsMerge(true)
    .atmosphereColor('#58a6ff')
    .atmosphereAltitude(0.24)
    .pointOfView({ lat: 18, lng: 18, altitude: 2.25 });

  globe.enablePointerInteraction(false);
  globe.resumeAnimation();

  const controls = globe.controls();
  controls.autoRotate = true;
  controls.autoRotateSpeed = 0.3;
  controls.enableZoom = false;
  controls.enablePan = false;
  controls.enableRotate = false;

  const BASE = window.bricsBasePath || '/';
  fetch(`${BASE}media/templates/site/tpl_brics_freight_premium/data/routes.json`)
    .then((res) => res.json())
    .then((data) => {
      const routes = data.routes || [];

      const arcs = routes.map((route) => {
        const color = modeColors[route.mode] || 'rgba(88, 166, 255, 0.95)';
        return {
          startLat: Number(route.from.lat),
          startLng: Number(route.from.lng),
          endLat: Number(route.to.lat),
          endLng: Number(route.to.lng),
          color: [color, color],
          label: `From ${route.from.country} → ${route.to.country}<br/>Cargo: ${route.cargo}<br/>Mode: ${route.mode}`,
        };
      });

      const points = routes.flatMap((route) => {
        const color = modeColors[route.mode] || 'rgba(88, 166, 255, 0.95)';
        return [
          { lat: Number(route.from.lat), lng: Number(route.from.lng), color },
          { lat: Number(route.to.lat), lng: Number(route.to.lng), color },
        ];
      });

      globe.arcsData(arcs).pointsData(points);
    })
    .catch(() => { });
})();