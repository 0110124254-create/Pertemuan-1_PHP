<?php
// Menyiapkan nilai awal agar formulir tetap aman saat pertama kali dibuka.
$nama = '';
$email = '';
$nilai = '';
$errors = [];
$status = null;

// Memproses data hanya setelah tombol proses dikirim melalui POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses'])) {
    $nama = isset($_POST['nama']) && is_string($_POST['nama']) ? $_POST['nama'] : '';
    $email = isset($_POST['email']) && is_string($_POST['email']) ? $_POST['email'] : '';
    $nilai = isset($_POST['nilai']) && is_string($_POST['nilai']) ? $_POST['nilai'] : '';

    $namaBersih = trim($nama);
    $emailBersih = trim($email);
    $nilaiBersih = trim($nilai);

    // Memastikan semua kolom terisi dan format data sesuai.
    if ($namaBersih === '' || $emailBersih === '' || $nilaiBersih === '') {
        $errors[] = 'Semua kolom wajib diisi.';
    }

    if ($emailBersih !== '' && !filter_var($emailBersih, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format e-mail tidak valid.';
    }

    if ($nilaiBersih !== '' && (!is_numeric($nilaiBersih) || $nilaiBersih < 0 || $nilaiBersih > 100)) {
        $errors[] = 'Nilai ujian harus berupa angka antara 0 dan 100.';
    }

    // Menentukan keterangan hanya jika semua data valid.
    if (empty($errors)) {
        if ((float) $nilaiBersih >= 70) {
            $status = 'Lulus';
        } else {
            $status = 'Remedial';
        }
    }
}

// Mengamankan setiap data sebelum ditampilkan kembali ke halaman.
$namaAman = htmlspecialchars($nama, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$emailAman = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$nilaiAman = htmlspecialchars($nilai, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Nilai Ujian</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 32px 16px;
            background: #f3f6fa;
            color: #243247;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 560px;
            margin: 0 auto;
            padding: 28px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(36, 50, 71, 0.1);
        }

        h1 {
            margin: 0 0 24px;
            text-align: center;
            font-size: 1.6rem;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd4df;
            border-radius: 6px;
            font: inherit;
        }

        input:focus {
            border-color: #2563eb;
            outline: 2px solid rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            margin: 0 0 16px;
            color: #c62828;
        }

        .result {
            margin-top: 24px;
            padding: 18px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .result h2 {
            margin: 0 0 12px;
            font-size: 1.2rem;
        }

        .result p {
            margin: 8px 0;
            overflow-wrap: anywhere;
        }

        .lulus {
            color: #16803c;
            font-weight: 700;
        }

        .remedial {
            color: #d97706;
            font-weight: 700;
        }

        @media (max-width: 480px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 22px 18px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Form Nilai Ujian</h1>

        <form method="POST" action="">
            <div class="field">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= $namaAman ?>" required>
            </div>

            <div class="field">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?= $emailAman ?>" required>
            </div>

            <div class="field">
                <label for="nilai">Nilai Ujian</label>
                <input type="number" id="nilai" name="nilai" min="0" max="100" step="any" value="<?= $nilaiAman ?>" required>
            </div>

            <button type="submit" name="proses" value="1">Proses</button>
        </form>

        <?php if (!empty($errors)): ?>
            <div class="result" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p class="error"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif ($status !== null): ?>
            <section class="result" aria-live="polite">
                <h2>Hasil Ujian</h2>
                <p><strong>Nama:</strong> <?= $namaAman ?></p>
                <p><strong>E-mail:</strong> <?= $emailAman ?></p>
                <p><strong>Nilai Ujian:</strong> <?= $nilaiAman ?></p>
                <p><strong>Keterangan:</strong> <span class="<?= $status === 'Lulus' ? 'lulus' : 'remedial' ?>"><?= htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span></p>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
