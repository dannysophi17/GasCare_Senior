// Seleccionar elementos del DOM para el menú de navegación
const menuToggle = document.getElementById("menu-toggle");
const navLinks = document.getElementById("nav-links");

// Si los elementos existen, agregar funcionalidad al menú móvil
if (menuToggle && navLinks) {
  // Evento para alternar la visibilidad del menú al hacer clic en el botón
  menuToggle.addEventListener("click", () => {
    navLinks.classList.toggle("show"); // Mostrar/ocultar el menú

    // Cambiar el ícono del botón entre hamburguesa y X
    const icon = menuToggle.querySelector("i");
    if (navLinks.classList.contains("show")) {
      icon.classList.remove("fa-bars");
      icon.classList.add("fa-xmark");
    } else {
      icon.classList.remove("fa-xmark");
      icon.classList.add("fa-bars");
    }
  });

  // Para cada enlace del menú, ocultar el menú al hacer clic (en móviles)
  const navItems = navLinks.querySelectorAll("a");
  navItems.forEach((item) => {
    item.addEventListener("click", () => {
      if (window.innerWidth <= 900) {
        navLinks.classList.remove("show");
      }
    });
  });
}

// Seleccionar elementos del DOM para el medidor de riesgo
const meterButtons = document.querySelectorAll(".meter-btn");
const meterIndicator = document.getElementById("meter-indicator");
const riskBadge = document.getElementById("risk-badge");
const lecturaGasInput = document.getElementById("lectura_gas");
const hero = document.getElementById("inicio");
const heroMessage = document.getElementById("hero-message");
const heroTopCard = document.getElementById("hero-top-card");
const heroBottomCard = document.getElementById("hero-bottom-card");

// Seleccionar elementos para el panel de información flotante
const infoFab = document.getElementById("info-fab");
const infoDrawer = document.getElementById("info-drawer");
const infoClose = document.getElementById("info-close");

// Configuración de los estados del medidor de riesgo
// Cada estado define la posición, texto, clase CSS, color y mensajes para la interfaz
const meterConfig = {
  safe: {
    left: "18%", // Posición del indicador en la barra
    text: "Normal", // Texto del badge
    badgeClass: "safe-badge", // Clase CSS para el badge
    borderColor: "#2e8b57", // Color del borde del indicador
    heroText: "El ambiente del hogar se mantiene estable. No se detecta riesgo en este momento.", // Mensaje en la sección hero
    topTitle: "Sensor activo", // Título de la tarjeta superior
    topSubtitle: "Lectura estable", // Subtítulo de la tarjeta superior
    bottomTitle: "Respuesta preventiva", // Título de la tarjeta inferior
    bottomSubtitle: "Monitoreo continuo" // Subtítulo de la tarjeta inferior
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

// Función que actualiza la vista del medidor según el nivel de riesgo seleccionado
function updateMeter(level) {
  // Obtener la configuración correspondiente al nivel
  const config = meterConfig[level];
  // Si no existe configuración o elementos del DOM, salir de la función
  if (!config || !meterIndicator || !riskBadge) return;

  // Actualizar la posición del indicador en la barra
  meterIndicator.style.left = config.left;
  // Cambiar el color del borde del indicador
  meterIndicator.style.borderColor = config.borderColor;

  // Actualizar el texto del badge de riesgo
  riskBadge.textContent = config.text;
  // Remover clases anteriores y agregar la nueva clase del badge
  riskBadge.classList.remove("safe-badge", "warning-badge", "danger-badge");
  riskBadge.classList.add(config.badgeClass);

  // Actualizar los botones del medidor: remover 'active' de todos y agregar al correspondiente
  meterButtons.forEach((button) => {
    button.classList.remove("active");
    if (button.dataset.level === level) {
      button.classList.add("active");
    }
  });

  // Actualizar el atributo 'data-state' de la sección hero
  if (hero) hero.setAttribute("data-state", level);
  // Actualizar el mensaje de la sección hero
  if (heroMessage) heroMessage.textContent = config.heroText;
  // Actualizar el contenido de las tarjetas flotantes
  if (heroTopCard) heroTopCard.innerHTML = `<strong>${config.topTitle}</strong><span>${config.topSubtitle}</span>`;
  if (heroBottomCard) heroBottomCard.innerHTML = `<strong>${config.bottomTitle}</strong><span>${config.bottomSubtitle}</span>`;
}

// Función que convierte una lectura de gas en ppm a un nivel de riesgo
function getLevelFromReading(value) {
  const ppm = Number(value); // Convertir el valor a número
  if (isNaN(ppm) || ppm < 0) return "safe"; // Si no es válido o negativo, devolver 'safe'
  if (ppm <= 300) return "safe"; // Nivel normal: 0-300 ppm
  if (ppm <= 600) return "warning"; // Nivel de precaución: 301-600 ppm
  return "danger"; // Nivel crítico: >600 ppm
}

// Agregar eventos a los botones del medidor para cambiar el estado manualmente
meterButtons.forEach((button) => {
  button.addEventListener("click", () => {
    updateMeter(button.dataset.level); // Actualizar el medidor al nivel del botón clicado
  });
});

// Agregar evento al input de lectura de gas para actualizar automáticamente
if (lecturaGasInput) {
  lecturaGasInput.addEventListener("input", (event) => {
    // Obtener el nivel basado en el valor del input y actualizar el medidor
    updateMeter(getLevelFromReading(event.target.value));
  });
}

// Funcionalidad del panel de información flotante
if (infoFab && infoDrawer) {
  // Mostrar/ocultar el panel al hacer clic en el botón flotante
  infoFab.addEventListener("click", () => {
    infoDrawer.classList.toggle("show");
  });
}

if (infoClose && infoDrawer) {
  // Cerrar el panel al hacer clic en el botón de cerrar
  infoClose.addEventListener("click", () => {
    infoDrawer.classList.remove("show");
  });
}

// Cerrar el panel si se hace clic fuera de él
document.addEventListener("click", (event) => {
  if (!infoDrawer || !infoFab) return;

  const clickedInsideDrawer = infoDrawer.contains(event.target); // Verificar si el clic fue dentro del drawer
  const clickedFab = infoFab.contains(event.target); // Verificar si el clic fue en el fab

  // Si no fue dentro del drawer ni en el fab, cerrar el panel
  if (!clickedInsideDrawer && !clickedFab) {
    infoDrawer.classList.remove("show");
  }
});

// Estado inicial del medidor: establecer en 'safe'
updateMeter("safe");
