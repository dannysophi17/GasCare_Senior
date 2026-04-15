<?php
include("conexion.php");

$sql = "SELECT * FROM registros ORDER BY fecha DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | GasCare Senior</title>
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
      padding: 32px 20px 50px;
    }

    .container {
      width: min(1180px, 95%);
      margin: 0 auto;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 28px;
    }

    .title-box h1 {
      font-size: clamp(2rem, 4vw, 2.8rem);
      line-height: 1.15;
      margin-bottom: 10px;
    }

    .title-box p {
      color: var(--text-light);
      max-width: 720px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      padding: 14px 20px;
      border-radius: 14px;
      font-weight: 600;
      transition: 0.3s ease;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: var(--white);
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .table-wrap {
      background: rgba(255,255,255,0.96);
      border-radius: 28px;
      box-shadow: var(--shadow);
      overflow: hidden;
      border: 1px solid rgba(73, 182, 117, 0.10);
    }

    .table-scroll {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 980px;
    }

    thead {
      background: rgba(73, 182, 117, 0.08);
    }

    th, td {
      padding: 18px 16px;
      text-align: left;
      border-bottom: 1px solid #eee8e0;
      vertical-align: top;
    }

    th {
      font-size: 0.94rem;
      color: var(--primary-dark);
    }

    td {
      font-size: 0.95rem;
      color: var(--text-light);
    }

    tr:hover td {
      background: rgba(255, 249, 244, 0.65);
    }

    .status {
      display: inline-block;
      padding: 8px 12px;
      border-radius: 999px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .status.safe {
      background: rgba(73, 182, 117, 0.12);
      color: var(--primary-dark);
    }

    .status.warning {
      background: rgba(244, 184, 96, 0.20);
      color: #a86f13;
    }

    .status.danger {
      background: rgba(232, 93, 93, 0.14);
      color: var(--danger);
    }

    .empty {
      padding: 30px;
      color: var(--text-light);
    }

    @media (max-width: 760px) {
      body {
        padding-top: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="topbar">
      <div class="title-box">
        <h1>Dashboard de GasCare Senior</h1>
        <p>
          Aquí puedes consultar los registros enviados desde el formulario del sistema.
        </p>
      </div>

      <a href="index.html" class="btn">Volver al sitio</a>
    </div>

    <div class="table-wrap">
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>Dirección</th>
              <th>Teléfono</th>
              <th>Habitantes</th>
              <th>Correo familiar</th>
              <th>Lectura</th>
              <th>Estado</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while($row = $result->fetch_assoc()): ?>
                <?php
                  $lectura = (int)$row['lectura_gas'];
                  $estado = "Normal";
                  $estadoClase = "safe";

                  if ($lectura > 300 && $lectura <= 600) {
                      $estado = "Precaución";
                      $estadoClase = "warning";
                  }

                  if ($lectura > 600) {
                      $estado = "Crítico";
                      $estadoClase = "danger";
                  }
                ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                  <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                  <td>
                    <?php echo htmlspecialchars($row['habitante1_nombre'] . " " . $row['habitante1_apellido']); ?><br>
                    <?php echo htmlspecialchars($row['habitante2_nombre'] . " " . $row['habitante2_apellido']); ?>
                  </td>
                  <td><?php echo htmlspecialchars($row['correo_familiar']); ?></td>
                  <td><?php echo htmlspecialchars($row['lectura_gas']); ?> ppm</td>
                  <td>
                    <span class="status <?php echo $estadoClase; ?>">
                      <?php echo $estado; ?>
                    </span>
                  </td>
                  <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="empty">
                  Aún no hay registros guardados.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>