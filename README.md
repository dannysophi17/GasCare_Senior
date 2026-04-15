# GasCare Senior

GasCare Senior es una propuesta que muestra cómo se puede usar IoT para mejorar la seguridad en el hogar, especialmente cuando hay riesgo de fugas de gas y viven adultos mayores.

El proyecto combina una página web, un backend en PHP, una base de datos en MySQL y una simulación con ESP32.

---

## Sobre el proyecto

La idea es simple. Muchas fugas de gas pasan desapercibidas hasta que ya es tarde. Este sistema intenta mostrar cómo se podría detectar una situación de riesgo a tiempo y reaccionar.

El usuario ingresa datos del hogar junto con una lectura estimada del gas. A partir de ese valor, el sistema interpreta el nivel de riesgo y guarda el registro para poder consultarlo después.

---

## Cómo funciona

El flujo es el siguiente:

- Se ingresan los datos del hogar en el formulario  
- Se registra una lectura estimada en ppm  
- El sistema clasifica el nivel de riesgo  
- Los datos se guardan en la base de datos  
- El dashboard muestra los registros más recientes  

---

## Escala de riesgo

Las lecturas se interpretan así:

- 0 a 300 ppm → Normal  
- 301 a 600 ppm → Precaución  
- 601 a 1000 ppm → Crítico  

Esta misma lógica se usa tanto en la web como en la simulación del ESP32.

---

## Interfaz principal

Aquí el usuario entiende el propósito del sistema y puede interactuar con el formulario.

![Inicio](./img/inicio.png)

---

## Formulario

Permite registrar:

- Dirección del hogar  
- Teléfono  
- Habitantes  
- Lectura estimada del gas en ppm  

![Formulario](./img/formulario.png)

---

## Dashboard

Muestra los registros guardados con su nivel de riesgo.

La página se actualiza automáticamente cada 10 segundos.

![Dashboard](./img/dashboard.png)

---

## Lógica del sistema

En la simulación, el ESP32 toma una lectura analógica del sensor y la convierte a ppm usando una escala interna.

```cpp
map(valor, 0, 4095, 0, 1000);
