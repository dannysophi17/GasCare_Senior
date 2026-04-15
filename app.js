// Selección de elementos en la página
const menuToggle = document.getElementById("menu-toggle");
const navLinks = document.getElementById("nav-links");

if (menuToggle && navLinks) {
  menuToggle.addEventListener("click", () => {
    navLinks.classList.toggle("show");

    const icon = menuToggle.querySelector("i");

    if (navLinks.classList.contains("show")) {
      icon.classList.remove("fa-bars");
      icon.classList.add("fa-xmark");
    } else {
      icon.classList.remove("fa-xmark");
      icon.classList.add("fa-bars");
    }
  });

  const navItems = navLinks.querySelectorAll("a");
  navItems.forEach((item) => {
    item.addEventListener("click", () => {
      if (window.innerWidth <= 900) {
        navLinks.classList.remove("show");
      }
    });
  });
}

const meterButtons = document.querySelectorAll(".meter-btn");
const meterIndicator = document.getElementById("meter-indicator");
const riskBadge = document.getElementById("risk-badge");
const lecturaGasInput = document.getElementById("lectura_gas");
const hero = document.getElementById("inicio");
const heroMessage = document.getElementById("hero-message");
const heroTopCard = document.getElementById("hero-top-card");
const heroBottomCard = document.getElementById("hero-bottom-card");

const infoFab = document.getElementById("info-fab");
const infoDrawer = document.getElementById("info-drawer");
const infoClose = document.getElementById("info-close");

// Configuración de los estados del medidor
const meterConfig = {
  safe: {
    left: "18%",
    text: "Normal",
    badgeClass: "safe-badge",
    borderColor: "#2e8b57",
    heroText: "El ambiente del hogar se mantiene estable. No se detecta riesgo en este momento.",
    topTitle: "Sensor activo",
    topSubtitle: "Lectura estable",
    bottomTitle: "Respuesta preventiva",
    bottomSubtitle: "Monitoreo continuo"
  },
  warning: {
    left: "55%",
    text: "Precaución",
    badgeClass: "warning-badge",
    borderColor: "#b77819",
    heroText: "Se detecta un aumento en el nivel de gas. Conviene revisar el entorno y mantenerse atento.",
    topTitle: "Lectura elevada",
    topSubtitle: "Revisión sugerida",
    bottomTitle: "Estado preventivo",
    bottomSubtitle: "Atención recomendada"
  },
  danger: {
    left: "88%",
    text: "Crítico",
    badgeClass: "danger-badge",
    borderColor: "#e85d5d",
    heroText: "Nivel de gas peligroso. El sistema activa alertas y se recomienda actuar de inmediato.",
    topTitle: "Alerta activa",
    topSubtitle: "Nivel crítico",
    bottomTitle: "Protección en curso",
    bottomSubtitle: "Respuesta inmediata"
  }
};

// Actualiza la vista del medidor según el estado seleccionado
function updateMeter(level) {
  const config = meterConfig[level];
  if (!config || !meterIndicator || !riskBadge) return;

  meterIndicator.style.left = config.left;
  meterIndicator.style.borderColor = config.borderColor;

  riskBadge.textContent = config.text;
  riskBadge.classList.remove("safe-badge", "warning-badge", "danger-badge");
  riskBadge.classList.add(config.badgeClass);

  meterButtons.forEach((button) => {
    button.classList.remove("active");
    if (button.dataset.level === level) {
      button.classList.add("active");
    }
  });

  if (hero) hero.setAttribute("data-state", level);
  if (heroMessage) heroMessage.textContent = config.heroText;
  if (heroTopCard) heroTopCard.innerHTML = `<strong>${config.topTitle}</strong><span>${config.topSubtitle}</span>`;
  if (heroBottomCard) heroBottomCard.innerHTML = `<strong>${config.bottomTitle}</strong><span>${config.bottomSubtitle}</span>`;
}

// Convierte la lectura en ppm a un nivel de riesgo
function getLevelFromReading(value) {
  const ppm = Number(value);
  if (isNaN(ppm) || ppm < 0) return "safe";
  if (ppm <= 300) return "safe";
  if (ppm <= 600) return "warning";
  return "danger";
}

// Eventos de los botones del medidor
meterButtons.forEach((button) => {
  button.addEventListener("click", () => {
    updateMeter(button.dataset.level);
  });
});

// Actualiza el medidor cuando cambia la lectura manual
if (lecturaGasInput) {
  lecturaGasInput.addEventListener("input", (event) => {
    updateMeter(getLevelFromReading(event.target.value));
  });
}

// Muestra u oculta el panel de información
if (infoFab && infoDrawer) {
  infoFab.addEventListener("click", () => {
    infoDrawer.classList.toggle("show");
  });
}

if (infoClose && infoDrawer) {
  infoClose.addEventListener("click", () => {
    infoDrawer.classList.remove("show");
  });
}

document.addEventListener("click", (event) => {
  if (!infoDrawer || !infoFab) return;

  const clickedInsideDrawer = infoDrawer.contains(event.target);
  const clickedFab = infoFab.contains(event.target);

  if (!clickedInsideDrawer && !clickedFab) {
    infoDrawer.classList.remove("show");
  }
});

// Estado inicial del medidor
updateMeter("safe");
