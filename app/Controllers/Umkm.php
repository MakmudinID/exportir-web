<?php

namespace App\Controllers;

class Umkm extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function dashboard()
    {
        //Profil
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Dashboard';
        // $data['js'] = array("umkm-dashboard.js?r=" . uniqid());
        $data['main_content']   = 'umkm/dashboard';
        echo view('template/adminlte', $data);
    }

    public function profil()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Profil';
        $data['js'] = array("umkm-profil.js?r=" . uniqid());
        $data['get_profil'] = $this->server_side->get_profil();
        $data['propinsi'] = $this->db->query('select * from tbl_propinsi')->getResult();
        // var_dump($data);
        $data['main_content']   = 'umkm/profil';
        echo view('template/adminlte', $data);
    }

    public function edit_profil()
    {
        $id = $this->request->getPost('id');
        $foto = $this->request->getFile('foto');
        $data['nama'] = $this->request->getPost('nama');
        $data['email'] = $this->request->getPost('email');
        $data['no_hp'] = $this->request->getPost('nohp');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-user/', $foto->getName());
            $filepath = base_url() . '/assets/photo-user/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = $this->request->getPost('foto_');
        }

        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $result = $this->server_side->updateRows($id, $data, 'tbl_pengguna');
        if ($result) {
            $r['result'] = true;
        } else {
            $r['result'] = false;
        }

        return json_encode($r);
    }

    public function edit_umkm()
    {
        $id = $this->request->getPost('id_umkm');
        $foto = $this->request->getFile('foto_umkm');
        $data['nama'] = $this->request->getPost('nama_umkm');
        $data['deskripsi'] = $this->request->getPost('deskripsi_umkm');
        $data['alamat'] = $this->request->getPost('alamat');
        $data['city_id'] = $this->request->getPost('kota');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-umkm/', $foto->getName());
            $filepath = base_url() . '/assets/photo-umkm/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = $this->request->getPost('foto_umkm_');
        }

        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $result = $this->server_side->updateRows($id, $data, 'tbl_umkm');
        if ($result) {
            $r['result'] = true;
        } else {
            $r['result'] = false;
        }

        return json_encode($r);
    }

    public function kerjasama()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kontrak Perjanjian';
        $data['js'] = array("reseller-kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'reseller/kerjasama';
        echo view('template/adminlte', $data);
    }

    public function kerjasama_detail($no_kerjasama)
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kerjasama Saya';
        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);

        if($data['kerjasama']->status == 'BELUM_UPLOAD'){
            return redirect()->route('reseller/kerjasama');
        }

        $data['js'] = array("reseller-kerjasama-detail.js?r=" . uniqid());
        $data['main_content']   = 'reseller/kerjasama_detail';
        echo view('template/adminlte', $data);
    }

    public function kerjasama_pdf($no_kerjasama)
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - ' . $no_kerjasama);

        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);

        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Dokumen Perjanjian Kerjasama - ' . $no_kerjasama . '.pdf', 'I'); // opens in browser
    }

    public function kerjasama_pdf_download($no_kerjasama)
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - ' . $no_kerjasama);

        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);

        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Dokumen Perjanjian Kerjasama - ' . $no_kerjasama . '.pdf', 'D'); // opens in browser
    }

    public function transaksi()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi';
        $data['js'] = array("umkm-transaksi.js?r=" . uniqid());
        $data['main_content']   = 'umkm/transaksi';
        echo view('template/adminlte', $data);
    }

    public function transaksi_detail($kode_transaksi)
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi';
        $data['js'] = array("umkm-transaksi-detail.js?r=" . uniqid());
        $data['transaksi'] = $this->server_side->transaksi_in_kode_detail($kode_transaksi);
        $data['main_content']   = 'umkm/transaksi_detail';
        echo view('template/adminlte', $data);
    }

    public function transaksi_()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if ($this->request->getPost('status') == 'ALL') {
            $status = '';
        } else {
            $status = $this->request->getPost('status');
        }

        $list = $this->transaksi->limitRowstTransaksiUMKM($status, $start_date, $end_date);

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row['tanggal_transaksi'] = $field->create_date;
            $row['kode_transaksi'] = $field->kode_transaksi;
            $row['penerima'] = $field->nama;
            $row['total_tagihan'] = 'Rp ' . number_format($field->jumlah + $field->ongkir, 0, ',', '.');

            if ($field->status == 'SEDANG_DIPROSES') {
                $row['status'] = '
                <div class="d-flex justify-content-center">
                    <span class="badge badge-warning">Perlu Disiapkan</span>
                    <div class="align-self-center ml-2 update-status" data-id_transaksi="' . $field->id . '" role="button"><i class="fas fa-edit"></i></div>
                </div>
                ';
            } else if ($field->status == 'SUDAH_DIKIRIM') {
                $row['status'] = '<span class="badge badge-primary">Sudah Dikirim</span>';
            } else if ($field->status == 'SELESAI') {
                $row['status'] = '<span class="badge badge-success">Selesai</span>';
            } else {
                $row['status'] = '<span class="badge badge-danger">Batal</span>';
            }

            $row['detail'] = '
            <div class="d-flex justify-content-center">
                <a href="' . base_url('umkm/transaksi/' . $field->kode_transaksi) . '" class="p-1"><i class="fas fa-search-plus"></i></a>
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

    public function produk()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }

        // echo session()->get('id_umkm'); die;
        $data['title'] = 'Produk';
        $data['js'] = array("umkm-produk.js?r=" . uniqid());
        $data['kategori'] = $this->server_side->getKategoriProdukById(session()->get('id_umkm'));
        // var_dump($data['kategori']); die;
        $data['main_content']   = 'umkm/produk';
        echo view('template/adminlte', $data);
    }

    public function produk_()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $cek = session()->get('id_umkm');
        $table = 'tbl_produk_umkm';
        $select = 'tbl_produk_umkm.*, tbl_kategori_produk.nama as nama_kategori';
        $join = array(
            array('tbl_kategori_produk', 'tbl_kategori_produk.id = tbl_produk_umkm.id_kategori')
        );
        $where = array(
            array('tbl_produk_umkm.id_umkm', $cek)
        );
        $column_order = array(NULL, 'tbl_produk_umkm.nama', 'nama_kategori', 'tbl_produk_umkm.qty');
        $column_search = array('tbl_produk_umkm.nama');
        $order = array('tbl_produk_umkm.nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump(session()->get('id'));die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['nama'] = $field->nama;
            $row['harga'] = number_format($field->harga);
            $row['kategori'] = $field->nama_kategori;
            $row['qty'] = $field->qty . " " . $field->satuan;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-harga="' . $field->harga . '" data-id_kategori="' . $field->id_kategori . '" data-nama="' . $field->nama . '" data-deskripsi="' . $field->deskripsi . '" data-qty="' . $field->qty . '" data-qty_min="' . $field->qty_min . '" data-satuan="' . $field->satuan . '" data-status="' . $field->status . '" data-foto="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_produk()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['id_kategori']   = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);
        $data['qty_min']  = htmlspecialchars($this->request->getPost('qty_min'), ENT_QUOTES);
        $data['harga']  = htmlspecialchars($this->request->getPost('harga'), ENT_QUOTES);
        $data['satuan']  = htmlspecialchars($this->request->getPost('satuan'), ENT_QUOTES);
        $data['weight']  = htmlspecialchars($this->request->getPost('weight'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-produk/', $foto->getName());
            $filepath = base_url() . '/assets/photo-produk/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }


        $r['result'] = true;

        $table = 'tbl_produk_umkm';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_produk()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['id_kategori']   = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);
        $data['harga']  = htmlspecialchars($this->request->getPost('harga'), ENT_QUOTES);
        $data['qty_min']  = htmlspecialchars($this->request->getPost('qty_min'), ENT_QUOTES);
        $data['satuan']  = htmlspecialchars($this->request->getPost('satuan'), ENT_QUOTES);
        $data['weight']  = htmlspecialchars($this->request->getPost('weight'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-produk/', $foto->getName());
            $filepath = base_url() . '/assets/photo-produk/' . $foto->getName();
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

        $r['result'] = true;

        $table = 'tbl_produk_umkm';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_produk()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $table = 'tbl_produk_umkm';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function kategori_produk()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kategori Produk';
        $data['js'] = array("umkm-kategori-produk.js?r=" . uniqid());
        $data['main_content']   = 'umkm/kategori-produk';
        echo view('template/adminlte', $data);
    }

    public function kategori_produk_()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $cek = session()->get('id_umkm');
        $table = 'tbl_kategori_produk';
        $select = '*';
        $join = NULL;
        $where = array(
            array('id_umkm', $cek)
        );
        $column_order = array(NULL, 'nama', 'status');
        $column_search = array('nama');
        $order = array('nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump(session()->get('id'));die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-status="' . $field->status . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_kategori()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_produk';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_kirim()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }

        $id = $this->request->getPost('id_transaksi');
        $no_resi = $this->request->getPost('no_resi');
        $foto = $this->request->getFile('foto');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-bukti-kirim/', $foto->getName());
            $filepath = base_url() . '/assets/photo-bukti-kirim/' . $foto->getName();
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

        $data['status'] = 'SUDAH_DIKIRIM';
        $data['no_resi'] = $no_resi;
        $data['tanggal_kirim'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_transaksi';

        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }else{
            $r['result'] = true;
        }
        echo json_encode($r);
        return;
    }

    public function update_kategori()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_produk';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_kategori()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $table = 'tbl_kategori_produk';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function kontrak_perjanjian()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Kontrak Perjanjian';
        $data['js'] = array("umkm-kontrak-perjanjian.js?r=" . uniqid());
        $data['main_content']  = 'umkm/kontrak-perjanjian';
        echo view('template/adminlte', $data);
    }

    public function kontrak_perjanjian_()
    {
        if (session()->get('role') != 'UMKM') {
            return redirect()->route('logout');
        }
        $id = session()->get('id');
        $cek = session()->get('id_umkm');
        $table = 'tbl_kerjasama';
        $select = 'tbl_pengguna.nama as nama_pengguna, tbl_umkm.nama as nama_umkm, tbl_kerjasama.*';
        $join = array(
            array('tbl_pengguna', 'tbl_pengguna.id = tbl_kerjasama.id_pengguna', 'left'),
            array('tbl_umkm', 'tbl_umkm.id = tbl_kerjasama.id_umkm', 'left')
        );;
        $where = array(
            array('tbl_kerjasama.id_umkm', $cek),
            array('tbl_kerjasama.id_pengguna', $id)
        );
        $column_order = array(NULL, 'nama_pengguna', 'nama_umkm', null, 'tbl_kerjasama.status');
        $column_search = array('nama_pengguna');
        $order = array('nama_pengguna' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama_pengguna;
            $row['umkm'] = $field->nama_umkm;
            $row['file'] = '<a href="' . $field->file_kerjasama . '" target="blank_">' . $field->file_kerjasama . '</a>';
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
}
