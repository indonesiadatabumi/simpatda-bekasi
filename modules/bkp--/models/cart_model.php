<?php

/**
 * Cart model
 * @author Daniel Hutauruk
 */
class Cart_model extends CI_Model { 
	/**
	 * validate add cart
	 */
	function validate_add_cart() {
		$setor_id = $this->input->post('setor_id');
		$jenis_pajak = $this->input->post('jenis_pajak');
		
		if ($setor_id != "" && $jenis_pajak != "") {
			$total_items = $this->cart->total_items();

			//check the cart is exist
			foreach ($this->cart->contents() as $items) {
				if ($items['id'] == $setor_id)
					return array('status' => false, 'msg' => "Data sudah pernah ditampung");
					
				if ($items['name'] != $jenis_pajak)
					return array('status' => false, 'msg' => "Jenis Pajak berbeda. Silahkan kosongkan terlebih dahulu.");
			}
			
			if (count($this->cart->contents()) > 5)
				return array('status' => false, 'msg' => "Limit tampungan hanya 5 data.");;
			
			//add data to cart using insert function
			$data = array(
					 	'id'      => "$setor_id",
                       	'qty'     => 1,
                       	'price'   => $this->input->post('total_pajak'),
                      	'name'    => "$jenis_pajak"
					);
			$this->cart->insert($data);	
			
			if($this->cart->total_items() > $total_items)			
				return array('status' => true, 'msg' => "Data berhasil ditampung");
			else 
				return array('status' => false, 'msg' => "Data gagal ditampung");
		} else {
			return array('status' => false, 'msg' => "Data gagal ditampung");
		}
	}
	
	/**
	 * get items of cart
	 */
	function get_cart_items() {
		$id = ""; $counter = 0;
		foreach ($this->cart->contents() as $items) {
			if ($items['id'] != "") {
				if ($counter == 0)
					$id = $items['id'];
				else 
					$id .= ", ".$items['id'];
			}
			
			$counter++;
		}
		
		return $id;
	}
}