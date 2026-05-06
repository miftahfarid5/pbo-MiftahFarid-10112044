<!DOCTYPE html>
<html>
<head>
    <title>Program Hitung Gaji Karyawan</title>
</head>
<body>
    <h2>PT. MAJU JAYA</h2>
    <h3>Program Hitung Gaji Karyawan</h3>

    <form action="proses_gaji.php" method="POST">
        Nama Karyawan : 
        <input type="text" name="nama"><br><br>

        Jenis Karyawan : 
        <select name="jenis">
            <option value="">-- Pilih --</option>
            <option value="Programmer">Programmer</option>
            <option value="Direktur">Direktur</option>
            <option value="PegawaiMingguan">Pegawai Mingguan</option>
        </select><br><br>

        Gaji Pokok : 
        <input type="number" name="gaji"><br><br>

        Masa Kerja (tahun) : 
        <input type="number" name="masaKerja" step="0.1"><br><br>

        <div id="fieldTambahan" style="display:none;">
            Harga Barang (per unit) : 
            <input type="number" name="hargaBarang"><br><br>

            Target Stock (unit) : 
            <input type="number" name="stockTarget"><br><br>

            Total Penjualan (unit) : 
            <input type="number" name="totalPenjualan"><br><br>
        </div>

        <input type="submit" value="Hitung">
    </form>

    <script>
        var selectJenis = document.querySelector('select[name="jenis"]');
        var divTambahan = document.getElementById('fieldTambahan');

        selectJenis.onchange = function() {
            if (this.value == 'PegawaiMingguan') {
                divTambahan.style.display = 'block';
            } else {
                divTambahan.style.display = 'none';
            }
        }
    </script>
</body>
</html>