<?php
include("conexion.php");

$direccion = $_POST['direccion'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$habitante1_nombre = $_POST['habitante1_nombre'] ?? '';
$habitante1_apellido = $_POST['habitante1_apellido'] ?? '';
$habitante2_nombre = $_POST['habitante2_nombre'] ?? '';
$habitante2_apellido = $_POST['habitante2_apellido'] ?? '';
$correo_familiar = $_POST['correo_familiar'] ?? '';
$lectura_gas = $_POST['lectura_gas'] ?? '';

$stmt = $conn->prepare("INSERT INTO registros (
    direccion,
    telefono,
    habitante1_nombre,
    habitante1_apellido,
    habitante2_nombre,
    habitante2_apellido,
    correo_familiar,
    lectura_gas
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssssi",
    $direccion,
    $telefono,
    $habitante1_nombre,
    $habitante1_apellido,
    $habitante2_nombre,
    $habitante2_apellido,
    $correo_familiar,
    $lectura_gas
);

$guardado = $stmt->execute();

$nivel = "Normal";
$nivelClase = "safe";

if ((int)$lectura_gas > 300 && (int)$lectura_gas <= 600) {
    $nivel = "Precaución";
    $nivelClase = "warning";
}

if ((int)$lectura_gas > 600) {
    $nivel = "Crítico";
    $nivelClase = "danger";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultado del registro | GasCare Senior</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #49b675;
      --primary-dark: #2e8b57;
      --secondary: #3a7ca5;
      --danger: #e85d5d;
      --warning: #f4b860;
      --bg-soft: #fff9f4;
      --text: #2b2b2b;
      --text-light: #666666;
      --white: #ffffff;
      --shadow: 0 14px 35px rgba(0, 0, 0, 0.08);
      --radius: 24px;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(180deg, #fffdfb 0%, #fff9f4 100%);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    .result-card {
      width: 100%;
      max-width: 820px;
      background: rgba(255,255,255,0.96);
      border-radius: 28px;
      box-shadow: var(--shadow);
      padding: 36px;
      border: 1px solid rgba(73, 182, 117, 0.10);
    }

    .tag {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 999px;
      font-size: 0.9rem;
      font-weight: 600;
      margin-bottom: 18px;
      background: rgba(73, 182, 117, 0.12);
      color: var(--primary-dark);
    }

    .tag.warning {
      background: rgba(244, 184, 96, 0.20);
      color: #a66a0d;
    }

    .tag.danger {
      background: rgba(232, 93, 93, 0.14);
      color: var(--danger);
    }

    h1 {
      font-size: clamp(2rem, 4vw, 2.8rem);
      line-height: 1.15;
      margin-bottom: 14px;
    }

    .message {
      color: var(--text-light);
      margin-bottom: 28px;
      font-size: 1rem;
    }

    .summary {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 18px;
      margin-bottom: 28px;
    }

    .box {
      background: #fffdfa;
      border: 1px solid #ece8e2;
      border-radius: 18px;
      padding: 18px;
    }

    .box h3 {
      font-size: 0.98rem;
      margin-bottom: 8px;
    }

    .box p {
      color: var(--text-light);
      font-size: 0.95rem;
    }

    .actions {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 10px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      padding: 14px 22px;
      border-radius: 14px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: var(--white);
    }

    .btn-secondary {
      background: var(--white);
      color: var(--secondary);
      border: 1px solid rgba(58, 124, 165, 0.18);
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .error-box {
      background: rgba(232, 93, 93, 0.08);
      border: 1px solid rgba(232, 93, 93, 0.16);
      color: #8f3030;
      border-radius: 18px;
      padding: 16px;
      margin-top: 18px;
    }

    @media (max-width: 700px) {
      .summary {
        grid-template-columns: 1fr;
      }

      .result-card {
        padding: 24px;
      }

      .actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="result-card">
    <span class="tag <?php echo $nivelClase === 'warning' ? 'warning' : ($nivelClase === 'danger' ? 'danger' : ''); ?>">
      Estado estimado: <?php echo $nivel; ?>
    </span>

    <?php if ($guardado): ?>
      <h1>Registro guardado correctamente</h1>
      <p class="message">
        La información del hogar fue almacenada en GasCare Senior. Ya puedes volver al formulario
        o revisar los datos guardados en el panel de registros.
      </p>

      <div class="summary">
        <div class="box">
          <h3>Dirección</h3>
          <p><?php echo htmlspecialchars($direccion); ?></p>
        </div>

        <div class="box">
          <h3>Teléfono de contacto</h3>
          <p><?php echo htmlspecialchars($telefono); ?></p>
        </div>

        <div class="box">
          <h3>Habitantes registrados</h3>
          <p>
            <?php echo htmlspecialchars($habitante1_nombre . " " . $habitante1_apellido); ?><br>
            <?php echo htmlspecialchars($habitante2_nombre . " " . $habitante2_apellido); ?>
          </p>
        </div>

        <div class="box">
          <h3>Lectura estimada del gas</h3>
          <p><?php echo htmlspecialchars($lectura_gas); ?> ppm</p>
        </div>
      </div>

      <div class="actions">
        <a href="index.html" class="btn btn-primary">Volver al inicio</a>
        <a href="dashboard.php" class="btn btn-secondary">Ver dashboard</a>
      </div>
    <?php else: ?>
      <h1>No fue posible guardar el registro</h1>
      <p class="message">
        Ocurrió un problema al intentar almacenar la información.
      </p>

      <div class="error-box">
        <?php echo htmlspecialchars($stmt->error); ?>
      </div>

      <div class="actions">
        <a href="index.html" class="btn btn-primary">Intentar de nuevo</a>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>