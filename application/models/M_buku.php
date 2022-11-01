<?php

class M_buku extends CI_Model
{
	private $_tbl_buku = 'buku';

	public function getData($id = null)
	{
		if ($id === null)
			return $this->db->query("SELECT b.*, k.nama_kategori FROM buku b JOIN kategori k ON b.kategori = k.id")->result_array();
		else
			return $this->db->query("SELECT b.*, k.nama_kategori FROM buku b JOIN kategori k ON b.kategori = k.id WHERE b.id = '$id'")->result_array();
		// if ($id === null)
		// 	return $this->db->get($this->_tbl_buku)->result_array();
		// else
		// 	return $this->db->get_where($this->_tbl_buku, ['id' => $id])->result_array();
	}

	public function insert_data($data)
	{
		$this->db->insert($this->_tbl_buku, $data);
		return $this->db->affected_rows();
	}

	public function update_data($data, $id)
	{
		$this->db->update($this->_tbl_buku, $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function delete_data($id)
	{
		$this->db->delete($this->_tbl_buku, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function importData($data)
	{
		$this->db->insert_batch($this->_tbl_buku, $data);
		return $this->db->affected_rows();
	}
}
