# GasCare Senior

GasCare Senior es una aplicación pensada para registrar lecturas estimadas de gas combustible en el hogar y mostrar el estado de riesgo de forma clara.

---

## Sobre el proyecto

Aquí se reúne una interfaz web, un pequeño backend en PHP y una base de datos MySQL para simular el flujo de un sistema de monitoreo doméstico.

El objetivo es recoger una lectura estimada en `ppm`, clasificarla con un medidor visual y guardar los registros para revisarlos en un dashboard.

---

## Lo que hace

- Recibe datos del hogar y una lectura estimada de gas.
- Guarda cada registro en MySQL.
- Muestra el historial de lecturas en `dashboard.php`.
- Ajusta el medidor y el hero según la escala de riesgo.
- Explica el papel del sensor `MQ-2` desde el botón de ayuda.

---

## Escala de riesgo

La aplicación trata las lecturas estimadas en `ppm` así:

- `0–300 ppm` → Normal
- `301–600 ppm` → Precaución
- `601–1000 ppm` → Crítico

---

## Archivos principales

- `index.html` — página principal con formulario y medidor
- `style.css` — diseño y adaptabilidad a pantallas pequeñas
- `app.js` — lógica del medidor y reacción del hero
- `conexion.php` — conexión a la base de datos
- `procesar.php` — recibe el formulario y guarda en la tabla `registros`
- `dashboard.php` — lista los registros con su ppm y estado
- `database.sql` — crea la base de datos y la tabla necesaria

---

## Cómo ponerlo en marcha

1. Copia la carpeta al servidor local (`htdocs/gascare_senior`).
2. Importa `database.sql` en MySQL.
3. Verifica `conexion.php` con:
   - host: `localhost`
   - usuario: `root`
   - contraseña: ``
   - base de datos: `gascare_db`
4. Abre `index.html` desde el servidor.
5. Llena el formulario y revisa los datos en `dashboard.php`.

---

## Qué verás

- Un formulario para registrar el hogar y la lectura en `ppm`.
- Un medidor que cambia de estado según la escala definida.
- Un panel de resultados que refresca cada 10 segundos.
- Una sección de ayuda que explica el sensor y el medidor.

---

## Capturas

![Inicio](./img/inicio.png)

![Formulario](./img/formulario.png)

![Dashboard](./img/dashboard.png)

---

## Consideraciones

- Este proyecto sirve para visualizar un flujo de trabajo de registro de gas.
- No es un detector certificado para uso real.
- El envío de correo en `procesar.php` depende de que el servidor PHP tenga `mail()` habilitado.

---

## Autora

**Daniela Sophia Coavas Arboza**

Proyecto académico enfocado en la seguridad del hogar y el cuidado de adultos mayores.
