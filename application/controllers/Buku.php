<?php

require_once APPPATH . 'controllers/Auth.php';

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Buku extends Auth
{
	function __construct()
	{
		parent::__construct();
		$this->cektoken();
		$this->load->model('m_buku', 'buku');
		$this->methods['index_get']['limit'] = 10;
	}

	public function index_get()
	{
		$id = $this->get('id_buku');

		$data_buku = $this->buku->getData($id);
		if ($data_buku) {
			$this->response([
				'status' => true,
				'message' => 'Berhasil mendapatkan data',
				'result' => $data_buku
			], self::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data tidak ditemukan'
			], self::HTTP_NOT_FOUND);
		}
	}

	public function index_post()
	{
		$file = $_FILES["file"];
		$filename = $file['name'];
		// var_dump($filename);
		// exit;
		if ($filename != "") {
			// Proses Import
			$this->import_post();
		} else {
			// Insert Biasa
			if ($this->_validationCheck() === false) {
				$this->response([
					'status' => false,
					'message' => strip_tags(validation_errors()),
				], self::HTTP_BAD_REQUEST);
			} else {
				$file = $_FILES['kover'];

				$path = "uploads/buku/";
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}


				$path_file = "";
				if (!empty($file['name'])) {
					$config['upload_path'] = './' . $path;
					$config['allowed_types'] = "jpg|jpeg|png|gif";
					$config['file_name'] = time();
					$config['max_size'] = 1024;
					$this->upload->initialize($config);
					if ($this->upload->do_upload('kover')) {
						// Mendapatkan file yang berhasil diupload
						$uploadData = $this->upload->data();
						$path_file = './' .  $path . $uploadData['file_name'];
					}
				}

				$data = [
					'judul' => $this->post('judul'),
					'penulis' => $this->post('penulis'),
					'tahun' => $this->post('tahun'),
					'penerbit' => $this->post('penerbit'),
					'stok' => $this->post('stok'),
					'harga_beli' => $this->post('harga_beli'),
					'harga_jual' => $this->post('harga_jual'),
					'kategori' => $this->post('id_kategori'),
					'cover' => $path_file
				];

				$saved = $this->buku->insert_data($data);
				if ($saved > 0) {
					$this->response([
						'status' => true,
						'message' => 'Berhasil menambahkan data',
					], self::HTTP_CREATED);
				} else {
					$this->response([
						'status' => false,
						'message' => 'Gagal menambahkan data',
					], self::HTTP_BAD_REQUEST);
				}
			}
		}
	}

	public function index_put()
	{
		// $this->form_validation->set_data($this->put());
		if ($this->_validationCheck() === false) {
			$this->response([
				'status' => false,
				'message' => strip_tags(validation_errors()),
			], self::HTTP_BAD_REQUEST);
		} else {
			$id = $this->input->post('id_buku');
			$data_buku = $this->buku->getData($id);
			$file = $_FILES['kover'];

			$path = "uploads/buku/";
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
			}

			$path_file = "";
			if (!empty($file['name'])) {
				$config['upload_path'] = './' . $path;
				$config['allowed_types'] = "jpg|jpeg|png|gif";
				$config['file_name'] = time();
				$config['max_size'] = 1024;
				$this->upload->initialize($config);
				if ($this->upload->do_upload('kover')) {
					@unlink($data_buku[0]['cover']);
					// Mendapatkan file yang berhasil diupload
					$uploadData = $this->upload->data();
					$path_file = './' .  $path . $uploadData['file_name'];
					$data['cover'] = $path_file;
				}
			}

			$data['judul'] = $this->input->post('judul');
			$data['penulis'] = $this->input->post('penulis');
			$data['tahun'] = $this->input->post('tahun');
			$data['penerbit'] = $this->input->post('penerbit');
			$data['stok'] = $this->input->post('stok');
			$data['harga_beli'] = $this->input->post('harga_beli');
			$data['harga_jual'] = $this->input->post('harga_jual');
			$data['kategori'] = $this->input->post('id_kategori');

			$updated = $this->buku->update_data($data, $id);
			if ($updated > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil memperbarui data',
				], self::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal memperbarui data',
				], self::HTTP_BAD_REQUEST);
			}
		}
	}

	private function _validationCheck()
	{
		$this->form_validation->set_rules(
			'judul',
			'Judul buku',
			'required',
			array(
				'required' => '{field} wajib diisi'
			)
		);

		$this->form_validation->set_rules(
			'penulis',
			'Penulis buku',
			'required',
			array(
				'required' => '{field} wajib diisi'
			)
		);

		$this->form_validation->set_rules(
			'tahun',
			'Tahun terbit',
			'required|numeric',
			array(
				'required' => '{field} wajib diisi',
				'numeric' => '{field} harus angka',
			)
		);

		$this->form_validation->set_rules(
			'penerbit',
			'Penerbit buku',
			'required',
			array(
				'required' => '{field} wajib diisi'
			)
		);

		$this->form_validation->set_rules(
			'stok',
			'Stok buku',
			'required|numeric',
			array(
				'required' => '{field} wajib diisi',
				'numeric' => '{field} harus angka',
			)
		);

		$this->form_validation->set_rules(
			'harga_beli',
			'Harga beli',
			'required|numeric',
			array(
				'required' => '{field} wajib diisi',
				'numeric' => '{field} harus angka',
			)
		);

		$this->form_validation->set_rules(
			'harga_jual',
			'Harga jual',
			'required|numeric',
			array(
				'required' => '{field} wajib diisi',
				'numeric' => '{field} harus angka',
			)
		);

		$this->form_validation->set_rules(
			'id_kategori',
			'Kategori buku',
			'required|numeric',
			array(
				'required' => '{field} wajib diisi',
				'numeric' => '{field} harus angka',
			)
		);

		return $this->form_validation->run();
	}

	public function index_delete()
	{
		$id = $this->delete('id_buku');
		if ($id === null) {
			$this->response([
				'status' => false,
				'message' => 'Silahkan masukkan id buku',
			], self::HTTP_NOT_FOUND);
		} else {
			$data_buku = $this->buku->getData($id);
			@unlink($data_buku[0]['cover']);
			$deleted = $this->buku->delete_data($id);
			if ($deleted > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil menghapus data',
				], self::HTTP_OK);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Gagal menghapus data',
				], self::HTTP_BAD_REQUEST);
			}
		}
	}

	public function import_post()
	{
		$file = $_FILES["file"];
		$filename = $file['name'];

		if (isset($filename)) {
			// Fungsi Import
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if ($ext == "xls") {
				$reader = new Xls();
			} else {
				$reader = new Xlsx();
			}

			$path = $file["tmp_name"];
			$spreadsheet = $reader->load($path);
			$sheet = $spreadsheet->getActiveSheet()->toArray();
			$data = [];
			foreach ($sheet as $key => $value) {
				if ($key == 0) continue;
				$judul = $value[1];
				$penulis = $value[2];
				$penerbit = $value[3];
				$tahun = $value[4];
				$stok = $value[5];
				$hb = $value[6];
				$hj = $value[7];
				$kategori = $value[8];

				if ($judul != "" && $penulis != "" && $penerbit != "" && $tahun != "" && $stok != "" && $hb != "" && $hj != "" && $kategori != "") {
					$data[] = [
						'judul' => $judul,
						'penulis' => $penulis,
						'tahun' => $tahun,
						'penerbit' => $penerbit,
						'stok' => $stok,
						'harga_beli' => $hb,
						'harga_jual' => $hj,
						'kategori' => $kategori,
					];
				}
			}

			$saved = $this->buku->importData($data);
			if ($saved > 0) {
				$this->response([
					'status' => true,
					'message' => 'Berhasil mengimport data',
				], self::HTTP_CREATED);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Tidak ada data yang diimport!',
				], self::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'Tidak ada file yang diimport!',
			], self::HTTP_NOT_FOUND);
		}
	}
}
