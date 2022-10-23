<?php
namespace App\Controllers;
class Reseller extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function profil()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Profil';
        $data['profil'] = $this->server_side->get_profil();
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['kota'] = $this->server_side->getKotaAll();
        $data['js'] = array("reseller-profil.js?r=" . uniqid());
        $data['main_content']   = 'reseller/profil';
        echo view('template/adminlte', $data);
    }

    public function transaksi()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Pesanan Saya';
        $data['js'] = array("reseller-transaksi.js?r=" . uniqid());
        $data['main_content']   = 'reseller/transaksi';
        echo view('template/adminlte', $data);
    }

    public function transaksi_()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if($this->request->getPost('status') == 'ALL'){
            $status="";
        }else{
            $status=$this->request->getPost('status');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if($this->request->getPost('status') == 'ALL'){
            $status="";
        }else{
            $status=$this->request->getPost('status');
        }

        $list = $this->transaksi->limitRowstTransaksi($status, $start_date, $end_date);

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['tanggal_transaksi'] = $field->create_date;
            $row['no_transaksi'] = $field->kode_transaksi;
            $row['umkm'] = $field->nama_umkm;
            $row['total_tagihan'] = 'Rp '.number_format($field->jumlah+$field->ongkir, 0,',','.');

            if($field->status == 'BELUM_DIBAYAR'){
                $row['status'] = '
                <div class="d-flex justify-content-center">
                    <div class="badge badge-danger">Belum Dibayar</div>
                    <div class="align-self-center ml-2 unggah-bukti-bayar" data-id_pembayaran="'.$field->id_pembayaran.'" role="button"><i class="fas fa-upload text-danger"></i></div>
                </div>';
            }else if($field->status == 'SEDANG_DIPROSES'){
                $row['status'] = '<span class="badge badge-warning">Sedang Diproses</span>';
            }else if($field->status == 'SUDAH_DIKIRIM'){
                $row['status'] = '<span class="badge badge-primary">Sudah Dikirim</span>';
            }else{
                $row['status'] = '<span class="badge badge-success">Selesai</span>';
            }

            $row['detail'] = '
            <div class="d-flex justify-content-center">
                <a href="'.base_url('reseller/transaksi/'.$field->kode_transaksi).'" class="p-1"><i class="fas fa-search-plus"></i></a>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->transaksi->countFilteredTransaksi($status, $start_date, $end_date),
            "recordsFiltered" => $this->transaksi->countFilteredTransaksi($status, $start_date, $end_date),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function transaksi_detail($kode_transaksi)
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Pesanan Saya';
        $data['js'] = array("reseller-transaksi-detail.js?r=" . uniqid());
        $data['transaksi'] = $this->server_side->transaksi_in_kode_detail($kode_transaksi);
        $data['main_content']   = 'reseller/transaksi_detail';
        echo view('template/adminlte', $data);
    }

    public function kerjasama()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kerjasama Saya';
        $data['js'] = array("reseller-kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'reseller/kerjasama';
        echo view('template/adminlte', $data);
    }

    public function kerjasama_detail($no_kerjasama)
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kerjasama Saya';
        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);
        $data['js'] = array("reseller-kerjasama-detail.js?r=" . uniqid());
        $data['main_content']   = 'reseller/kerjasama_detail';
        echo view('template/adminlte', $data);
    }

    public function kerjasama_pdf($no_kerjasama)
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - '.$no_kerjasama);
        
        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);
        
        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Dokumen Perjanjian Kerjasama.pdf','I'); // opens in browser
    }

    public function kerjasama_pdf_download($no_kerjasama)
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - '.$no_kerjasama);
        
        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);
        
        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('arjun.pdf','D'); // opens in browser
    }

    public function update_bayar()
    {
        $id = $this->request->getPost('id_pembayaran');
        $foto = $this->request->getFile('foto');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-bukti-bayar/', $foto->getName());
            $filepath = base_url() . '/assets/photo-bukti-bayar/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['bukti_url'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        }

        $data['status'] = 'MENUNGGU_KONFIRMASI';
        $data['keterangan'] = htmlspecialchars($this->request->getPost('keterangan'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_transaksi_pembayaran';

        $result = $this->server_side->updateRows($id, $data, $table);

        $data_transaksi['status'] = 'SEDANG_DIPROSES';
        $data_transaksi['edit_date'] = date('Y-m-d H:i:s');

        $table_transaksi = 'tbl_transaksi';
        $result = $this->server_side->updateRowsByField('id_pembayaran', $id, $data_transaksi, $table_transaksi);

        $r['result'] = true;
        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function kerjasama_pdf_upload()
    {
        $dokumen = $this->request->getFile('dokumen');
        $no_kerjasama = $this->request->getPost('no_kerjasama');
        if ($dokumen->getName() != '') {
            $dokumen->move('../public/assets/dokumen-kerjasama/', $dokumen->getName());
            $filepath = base_url() . '/assets/dokumen-kerjasama/' . $dokumen->getName();
            $path = $dokumen->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'pdf') {
                $data['file_kerjasama'] = $filepath;
                $data['status'] = 'SUDAH_UPLOAD';

                $table = 'tbl_transaksi_kerjasama';
                $result = $this->server_side->updateRowsByField('no_kerjasama', $no_kerjasama, $data, $table);
                $r['result'] = true;
                if (!$result) {
                    $r['result'] = false;
                    $r['title'] = 'Maaf Gagal Menyimpan!';
                    $r['icon'] = 'error';
                    $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
                }
                echo json_encode($r);
                return;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            echo 'ERROR';
            die;
        }
    }

    public function kerjasama_()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if($this->request->getPost('status') == 'ALL'){
            $status="";
        }else{
            $status=$this->request->getPost('status');
        }

        $list = $this->transaksi->limitRowsKerjasama($status, $start_date, $end_date);

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['tanggal_pengajuan'] = $field->create_date;
            $row['no_kerjasama'] = $field->no_kerjasama;
            $row['umkm'] = $field->nama_umkm;
            $progress = $this->transaksi->progress($field->lama_kerjasama, $field->no_kerjasama);

            $row['progress'] ='
                <div class="progress progress-sm active">
                  <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%">
                    <span class="sr-only">'.$progress.'% Complete</span>
                  </div>
                </div>
                <div class="align-self-center">'.$progress.'%</div>
            ';
            $row['kontrak'] = $field->lama_kerjasama.' Bulan';

            if($field->status == 'BELUM_UPLOAD'){
                $url = base_url('reseller/pdf/'.$field->no_kerjasama);

                $row['status'] = '
                <div class="d-flex justify-content-center">
                    <div class="badge badge-danger">Belum Unggah Dokumen</div>
                    <div class="align-self-center ml-2 unggah-perjanjian" data-no_kerjasama="'.$field->no_kerjasama.'" data-url="'.base_url('reseller/pdf_download/'.$field->no_kerjasama).'" role="button"><i class="fas fa-upload text-danger"></i></div>
                </div>';
            }else if($field->status == 'SUDAH_UPLOAD'){
                $url = $field->file_kerjasama;

                $row['status'] = '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
            }else{
                $url = $field->file_kerjasama;

                $row['status'] = '<span class="badge badge-success">Disetujui</span>';
            }

            $row['detail'] = '
            <div class="d-flex justify-content-center">
                <a href="'.$url.'" target="_blank" class="p-1"><i class="fas fa-file-pdf"></i></a>
                <a href="'.base_url('reseller/kerjasama/'.$field->no_kerjasama).'" class="p-1"><i class="fas fa-search-plus"></i></a>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->transaksi->countFilteredKerjasama($status, $start_date, $end_date),
            "recordsFiltered" => $this->transaksi->countFilteredKerjasama($status, $start_date, $end_date),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function berita()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Berita';
        $data['js'] = array("reseller-berita.js?r=" . uniqid());
        $data['kategori'] = $this->db->query('select * from tbl_berita_kategori')->getResult();
        $data['main_content']   = 'reseller/berita';
        echo view('template/adminlte', $data);
    }

    public function detail_berita($slug)
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Berita';
        $data['berita'] = $this->db->query('select tbl_berita.*, tbl_berita_kategori.nama as kategori from tbl_berita join tbl_berita_kategori on tbl_berita_kategori.id = tbl_berita.id_kategori where tbl_berita.slug=?', array($slug))->getRow();
        $data['main_content']   = 'reseller/berita-detail';
        echo view('template/adminlte', $data);
    }

    public function berita_()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita';
        $select = 'tbl_berita.*, tbl_berita_kategori.nama as nama_kategori';
        $join = array(
            array('tbl_berita_kategori', 'tbl_berita_kategori.id = tbl_berita.id_kategori')
        );
        $where = array(
            array('tbl_berita.flag', 'INFO RESELLER')
        );
        $column_order = array(NULL, NULL, 'tbl_berita.judul', 'nama_kategori', 'tbl_berita.slug', 'tbl_berita.flag', 'tbl_berita.penulis', 'tbl_berita.status');
        $column_search = array('tbl_berita.judul', 'nama_kategori');
        $order = array('tbl_berita.id' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['judul'] = $field->judul.'<br><small>'.$field->create_date.'</small>';
            $row['nama_kategori'] = $field->nama_kategori;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <a class="text-info align-items-center text-decoration-none detail mr-1" href="' .base_url('/reseller/detail-berita/'.$field->slug) . '" role="button"><i class="fa fa-eye mr-1"></i> Detail</a>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function update_profil()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }

        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $foto = $this->request->getFile('photo');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-user/', $foto->getName());
            $filepath = base_url() . '/assets/photo-user/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
                echo json_encode($r);
                return;
            }
        }
        $data['nama'] =  htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['tgl_lahir'] = htmlspecialchars($this->request->getPost('tgl_lahir'), ENT_QUOTES);
        $data['no_hp'] = htmlspecialchars($this->request->getPost('no_hp'), ENT_QUOTES);
        
        $password = htmlspecialchars($this->request->getPost('password'), ENT_QUOTES);
        $re_password = htmlspecialchars($this->request->getPost('re_password'), ENT_QUOTES);
        
        if($password != ''){
            if($password != $re_password){
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Ulangi Password tidak cocok!';
                echo json_encode($r);
                return;
            }else{
                $options = [
                    'cost' => 10,
                ];
                $data['password'] =  password_hash(htmlspecialchars($password, ENT_QUOTES), PASSWORD_BCRYPT, $options);        
            }
        }
        
        $data['alamat'] = htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES);
        $data['id_propinsi'] = htmlspecialchars($this->request->getPost('propinsi'), ENT_QUOTES);
        $data['id_kota'] = htmlspecialchars($this->request->getPost('kota'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_pengguna';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }else{
            $r['result'] = true;
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di simpan!';
        }
        echo json_encode($r);
        return;
    }

}
