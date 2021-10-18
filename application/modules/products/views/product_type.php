
//products controller
<?php 


function admin_add() {
		$data['product_type'] = $this->get_product_type();

}

function admin_edit() {

	$data['product_type'] = $this->get_product_type();
	$data['option']['product_type'] = $data['product_type'];
}
function get_product_type(){
		$query = ['Select Product Type','Product', 'Service', 'Product & Services']; 
		//print_r($query);
		return $query;
	}


	View file
	admin_add(products)

										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProduct_type" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[products][product_type]',$product_type, isset($values_posted['products']['product_type'])?$values_posted['products']['product_type']:'',"id='product_type' required='required' class='form-control select2' ");?>
													<?php echo form_error('data[products][product_code]'); ?>
												</div>
											</div>
										</div>

	admin_edit(products)


$input['product_type'] = array(
						"name" => "data[products][product_type]",
						"placeholder" => "Product Type (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "product_type",
					);

form field

										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProductType" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[products][product_type]', $product_type, isset($values_posted['products']['product_type'])?$values_posted['products']['product_type']:'','id="product_type" required="required" class="form-control select2"');?>
													
												      <?php echo form_error('product_type'); ?>
												</div>
											</div>
										</div>

?>