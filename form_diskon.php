<!DOCTYPE html>
<html>
<head>
    <title>Form Diskon</title>
</head>
<body>
    <h2>Form Hitung Diskon</h2>
    <form method="POST" action="proses_diskon.php">
        <table>
            <tr>
                <td>Punya Kartu Member?</td>
                <td>
                    <select name="kartu">
                        <option value="1">Ya </option>
                        <option value="0">Tidak </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Total Belanja</td>
                <td><input type="number" name="belanja" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="hitung" value="Hitung"></td>
            </tr>
        </table>
    </form>
</body>
</html>