# GasCare Senior

GasCare Senior es una propuesta que muestra cómo el IoT puede ayudar a mejorar la seguridad en el hogar, especialmente en casos donde hay riesgo de fugas de gas y viven adultos mayores.

El proyecto integra una página web, un backend en PHP con base de datos MySQL y un sistema físico con ESP32 que permite detectar cambios en el ambiente.

---

## Sobre el proyecto

Las fugas de gas pueden pasar desapercibidas hasta que ya representan un riesgo. Este sistema busca mostrar cómo se puede detectar ese cambio a tiempo y generar una respuesta básica.

El usuario registra los datos del hogar junto con una lectura de gas. Esa información se guarda y se puede visualizar en un dashboard.

---

## Cómo funciona

El sistema sigue este flujo:

- El usuario ingresa los datos del hogar en el formulario  
- Se registra una lectura de gas en ppm  
- El ESP32 envía los datos al servidor usando HTTP POST  
- El backend en PHP procesa la información  
- Los datos se guardan en MySQL  
- El dashboard muestra los registros actualizados  

---

## Escala de riesgo

Las lecturas se interpretan así:

- 0 a 300 ppm → Normal  
- 301 a 600 ppm → Precaución  
- 601 a 1000 ppm → Crítico  

Esta misma lógica se aplica tanto en la web como en el sistema físico.

---

## Interfaz

La página web permite entender el propósito del sistema y registrar los datos del hogar.

![Inicio](./img/inicio.png)

---

## Formulario

Permite registrar:

- Dirección  
- Teléfono  
- Habitantes  
- Lectura del gas en ppm  

![Formulario](./img/formulario.png)

---

## Dashboard

Muestra los registros almacenados con su nivel de riesgo.

Se actualiza automáticamente cada 10 segundos.

![Dashboard](./img/dashboard.png)

---

## Sistema con ESP32

El sistema utiliza:

- ESP32  
- Sensor MQ-2  
- LCD 16x2 I2C  
- LEDs  
- Buzzer  
- Servomotor  

El sensor MQ-2 entrega una lectura analógica que se convierte a un valor aproximado en ppm.

Dependiendo del valor detectado:

- Se encienden LEDs (verde, amarillo o rojo)  
- Se activa un buzzer como alerta  
- Un servomotor simula el cierre del gas  
- La LCD muestra la lectura y el estado  

Además, el ESP32 envía los datos al servidor para su almacenamiento.

---

## Conversión de lectura

La conversión de la lectura del sensor se realiza directamente en el ESP32 usando una escala ajustada según pruebas reales.

```cpp
int ppm = map(lecturaGas, rawMin, rawMax, 0, 1000);
ppm = constrain(ppm, 0, 1000);
