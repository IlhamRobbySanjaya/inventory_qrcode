<?php
class Qrcode_model extends CI_Model
{

    function get_barangqr()
    {
        $hasil = $this->db->get('barang');
        return $hasil;
    }

    function simpan_qr($idbarang, $namabarang, $stok, $satuanid, $jenisid, $image_name)
    {
        $data = array(
            'id_barang' => $idbarang,
            'nama_barang' => $namabarang,
            'stok' => $stok,
            'satuan_id'   => $satuanid,
            'jenis_id' => $jenisid,
            'qrcode'   => $image_name
        );
        $this->db->insert('barang', $data);
    }
}
