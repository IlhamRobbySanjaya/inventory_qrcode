<?php
class qrcodee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('qrcode_model'); //pemanggilan model barang
    }

    function index()
    {
        $data['data'] = $this->qrcode_model->get_barangqr();
        $this->load->view('barang_data', $data);
    }

    public function save()
    {
        $idbarang = $this->input->post('id_barang');
        $namabarang = $this->input->post('nama_barang');
        $satuanid = $this->input->post('satuan_id');
        $jenisid = $this->input->post('jenis_id');
        $stok = $this->input->post('stok');

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']        = './assets/'; //string, the default is application/cache/
        $config['errorlog']        = './assets/'; //string, the default is application/logs/
        $config['imagedir']        = './assets/images/'; //direktori penyimpanan qr code
        $config['quality']        = true; //boolean, the default is true
        $config['size']            = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $idbarang . '.png'; //buat name dari qr code sesuai dengan id_barang

        $params['data'] = $idbarang . $namabarang; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $this->qrcode_model->simpan_qr($idbarang, $namabarang, $stok, $satuanid, $jenisid, $image_name); //simpan ke database
        redirect('barang'); //redirect ke mahasiswa usai simpan data
    }
}
