<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Proses Diagnosis
$hasil_diagnosis = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diagnosis'])) {
    $gejala = [
        "muntah" => isset($_POST['gejala_muntah']),
        "demam" => isset($_POST['gejala_demam']),
        "lesu" => isset($_POST['gejala_lesu']),
        "nafsu_makan_turun" => isset($_POST['gejala_nafsu_makan']),
        "berat_badan_turun" => isset($_POST['gejala_berat_badan']),
        "batuk" => isset($_POST['gejala_batuk']),
        "diare" => isset($_POST['gejala_diare']),
        "kulit_gatal" => isset($_POST['gejala_kulit_gatal']),
    ];

    $penyakit_gejala = [
        "Cacingan" => ["muntah", "lesu", "nafsu_makan_turun", "berat_badan_turun"],
        "Infeksi Saluran Pernafasan" => ["batuk", "demam", "lesu"],
        "Gagal Ginjal" => ["muntah", "lesu", "diare", "nafsu_makan_turun"],
        "Feline Panleukopenia" => ["demam", "muntah", "diare", "lesu"],
        "Alergi Kulit" => ["kulit_gatal", "lesu"],
    ];

    $hasil_diagnosis = [];
    foreach ($penyakit_gejala as $penyakit => $daftar_gejala) {
        $skor = 0;
        foreach ($daftar_gejala as $gejala_penyakit) {
            if (!empty($gejala[$gejala_penyakit])) {
                $skor++;
            }
        }

        if ($skor / count($daftar_gejala) >= 0.5) {
            $hasil_diagnosis[] = $penyakit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar: Diagnosis Penyakit Kucing</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showTab(tabId) {
            // Menyembunyikan semua tab
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            // Menampilkan tab yang dipilih
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</head>
<body>
    <header>
        <h1>Sistem Pakar Diagnosis Penyakit Kucing</h1>
    </header>

    <div class="tabs">
        <button onclick="showTab('diagnosisTab')">Diagnosis</button>
        <button onclick="showTab('penyakitInfoTab')">Informasi Penyakit</button>
    </div>

    <!-- Tab Diagnosis -->
    <div id="diagnosisTab" class="tab-content" style="display:block;">
        <div class="form-container">
            <h2>Diagnosis Penyakit Kucing</h2>
            <form method="POST">
                <h3>Pilih Gejala yang Dialami Kucing:</h3>
                <label><input type="checkbox" name="gejala_muntah"> Muntah</label><br>
                <label><input type="checkbox" name="gejala_demam"> Demam</label><br>
                <label><input type="checkbox" name="gejala_lesu"> Lesu</label><br>
                <label><input type="checkbox" name="gejala_nafsu_makan"> Nafsu Makan Turun</label><br>
                <label><input type="checkbox" name="gejala_berat_badan"> Berat Badan Turun</label><br>
                <label><input type="checkbox" name="gejala_batuk"> Batuk</label><br>
                <label><input type="checkbox" name="gejala_diare"> Diare</label><br>
                <label><input type="checkbox" name="gejala_kulit_gatal"> Kulit Gatal</label><br>

                <button type="submit" name="diagnosis">Dapatkan Diagnosis</button>
            </form>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diagnosis'])): ?>
                <h3>Hasil Diagnosis:</h3>
                <?php if (!empty($hasil_diagnosis)): ?>
                    <ul>
                        <?php foreach ($hasil_diagnosis as $penyakit): ?>
                            <li><?php echo htmlspecialchars($penyakit); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Tidak ada penyakit yang teridentifikasi berdasarkan gejala yang Anda pilih.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tab Informasi Penyakit -->
    <div id="penyakitInfoTab" class="tab-content" style="display:none;">
        <h3>Informasi Penyakit Kucing</h3>
        <p><strong>Cacingan:</strong> Gejala: Muntah, Lesu, Nafsu makan turun, Berat badan turun</p>
        <p><strong>Infeksi Saluran Pernafasan:</strong> Gejala: Batuk, Demam, Lesu</p>
        <p><strong>Gagal Ginjal:</strong> Gejala: Muntah, Lesu, Diare, Nafsu makan turun</p>
        <p><strong>Feline Panleukopenia:</strong> Gejala: Demam, Muntah, Diare, Lesu</p>
        <p><strong>Alergi Kulit:</strong> Gejala: Kulit gatal, Lesu</p>
    </div>

    <footer>
        <p>&copy; 2024 Sistem Pakar Penyakit Kucing</p>
    </footer>
</body>
</html>
