<?php
$nilai = 75;

if ($nilai >100) {
    echo "Nilai tidak valid";
}elseif ($nilai >= 60) {
    echo "Lulus";
} else {
    echo "Tidak Lulus";
}
if ($nilai < 0) {
    echo "Nilai tidak valid";
}

?>