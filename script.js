// Tampilkan popup setelah form disubmit
document.addEventListener("DOMContentLoaded", function() {
    // Menggunakan AJAX untuk mendapatkan data dari PHP
    const jurusanRekomendasi = document.getElementById("jurusan_rekomendasi").value;
    if (jurusanRekomendasi) {
        document.getElementById("popup").style.display = "block";
        document.getElementById("overlay").style.display = "block"; // Tampilkan overlay
    }
});

// Fungsi untuk kembali ke form
function goBack() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none"; // Sembunyikan overlay
}