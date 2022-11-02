<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Surat Perjanjian Kerja Sama Usaha - <?= $kerjasama->no_kerjasama;?></title>
</head>

<body>

    <div id="container">
        <table style="width: 100%;">
            <tr>
                <td align="center">
                    <h3><u>Surat Perjanjian Kerja Sama Usaha</u></h3>
                    Nomor: <?= $kerjasama->no_kerjasama;?>
                </td>
            </tr>
        </table>
        <br>
        <br>

        <table style="width: 100%;">
            <tr>
                <td>Yang bertanda tangan di bawah ini:</td>
            </tr>
        </table>
        <br>

        <table style="width: 100%;">
            <tr>
                <td width="20%">Nama</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->nama;?></td>
            </tr>
            <tr>
                <td width="20%">Alamat</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->alamat;?></td>
            </tr>
            <tr>
                <td width="20%">No. Telepon</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->no_telepon;?></td>
            </tr>
            <tr>
                <td width="20%">No. KTP</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->no_ktp;?></td>
            </tr>
        </table>

        <br>
        <table style="width: 100%;">
            <tr>
                <td>
                    Yang mana disebut sebagai <b>PIHAK PERTAMA</b>
                </td>
            </tr>
        </table>
        <br>

        <table style="width: 100%;">
            <tr>
                <td width="20%">Nama Toko</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->nama_umkm;?></td>
            </tr>
            <tr>
                <td width="20%">Alamat</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->alamat_umkm;?></td>
            </tr>
            <tr>
                <td width="20%">No. Telepon</td>
                <td width="5%">:</td>
                <td><?= $kerjasama->telepon_umkm;?></td>
            </tr>
        </table>

        <br>
        <table style="width: 100%;">
            <tr>
                <td>
                    Selanjutnya disebut <b>PIHAK KEDUA</b>
                </td>
            </tr>
        </table>
        <br>

        <table style="width: 100%;">
            <tr>
                <td align="justify">Kedua belah pihak telah sepakat untuk mengadakan perjanjian kerjasama usaha yang akan di atur ke dalam peraturan berikut ini :</td>
            </tr>
        </table>
        <br>

        <table style="width:100%">
            <tr>
                <td width="5%">1</td>
                <td>Pihak kedua akan menitipkan produk ke pada pihak pertama dalam waktu <?= $kerjasama->lama_kerjasama;?> bulan sesuai yang di pilih. </td>
            </tr>
            <tr>
                <td width="5%">2</td>
                <td>Pihak pertama akan melaporakan hasil penjualan kepada pihak kedua setiap awal bulan dan akan menyerahkan omzet sebesar 85% dari hasil penjualan.</td>
            </tr>
            <tr>
                <td width="5%">3</td>
                <td>Pihak pertama akan membantu kegiatan promosi dan penjualan produk dari pihak Kedua ke pasar luar maupun dalam negeri dengan omzet sebesar 15% dari hasil penjualan.</td>
            </tr>        
            <tr>
                <td width="5%">4</td>
                <td>Apabila terjadi perselisihan maka kedua belah pihak sepakat untuk menyelesaikannya melalui jalur kekeluarga terlebih dahulu dan apabila tidak di temui maka penyelesaikan akan di bawa ke jalur hukum serta sistem kerjasama yang di buat tidak akan berlaku lagi.</td>
            </tr>        
        </table>

        <br>
        <br>

        <table style="width: 100%;">
            <tr>
                <td colspan="3" align="center">
                    Jakarta, <?= date('d-m-Y');?>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <b>Pihak Pertama</b>
                    <p><u><?= $kerjasama->nama;?></u></p>
                </td>
                <td align="center" valign="middle" width="100px">
                    <br><img src="<?=$foto?>" width="100px">
                </td>
                <td align="center">
                    <b>Pihak Kedua</b>
                    <p><u><?= $kerjasama->nama_umkm;?></u></p>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>