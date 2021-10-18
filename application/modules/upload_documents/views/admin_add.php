<?php 
// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted['data']) && !empty($values_posted['data']))
{ //print_r($values_posted);
	foreach($values_posted['data'] as $post_name => $post_value)
	{ //print_r($post_value);
		foreach ($post_value as $field_key => $field_value) {
			# code...
			$input[$field_key]['value'] = $field_value;
		}
	}
}

?>
<div>
<?php echo form_open_multipart(custom_constants::new_upload_document_url, ['class'=>'form-horizontal', 'id'=>'upload_document']); 
	//print_r($this->session);
	if(!isset($module) && $this->session->flashdata('message') !== FALSE) {
		$msg = $this->session->flashdata('message');?>
		<div class = "<?php echo $msg['class'];?>">
			<?php echo $msg['message'];?>
		</div>
	<?php } ?>

	<?php 
	/*$url = !isset($url)?'bank_accounts/edit_account/':$url;
	if(set_value('url'))
		$url = set_value('url');*/
	 ?>
	<input type="hidden" name="url" value="<?php echo !isset($url)?'upload_documents/new_document/':$url; ?>">
	<input type="hidden" name="module" value="<?php echo !isset($module)?'upload_documents':$module; ?>">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-book margin-r-5"></i> Document Upload</h3>
		</div><!-- /box-header -->
		<!-- form start -->
		<div class="box-body" style="overflow-x: scroll;">
			<table class="table" id="target">
				<thead>
					<tr>
					  <th>User Type</th>
					  <th>User</th>
					  <th>Document</th>
					  <th>Bg Image</th>
					  <th>Upload File</th>
					  <th>Write up</th>
					  <th>Priority</th>
					  <th>IS Active</th>
					  <th>Action</th>
					</tr>
				</thead>
				<tbody>
				 <?php //print_r($userDocuments);
				$count = count($userDocuments);
				if($count>0){
				foreach ($userDocuments as $userDocumentKey => $userDocumentValue) { ?>
					<tr id="<?php echo $userDocumentKey; ?>">
						<td>
							<input type="hidden" name="user_documents[<?php echo $userDocumentKey; ?>][id]" value="<?php echo $userDocumentValue['id'];?>" id="id_<?php echo $userDocumentKey;?>">
							<select name="user_documents[<?php echo $userDocumentKey;?>][user_type]" class="form-control select2 filter nochange" data-target="user_id_<?php echo $userDocumentKey;?>" data-link="upload_documents/type_wise_user" id="user_type_<?php echo $userDocumentKey;?>" style="width:100%">
								<option value="">Select User type</option>
								<?php 
								foreach ($option['typeLists'] as $userTypeKey => $userTypeValue) {
									?>
									<option value="<?php echo $userTypeKey; ?>" <?php echo ($userTypeKey==$userDocumentValue['user_type'])?"selected=selected":'' ?>><?php echo $userTypeValue; ?></option>
									<?php
								} ?>
							</select>
						
						</td>
						<td>
							<select name="user_documents[<?php echo $userDocumentKey;?>][user_id]" id="user_id_<?php echo $userDocumentKey;?>" class="form-control select2 nochange" style="width:100%">
								<option value="">Select User</option>
								<?php 
								foreach ($users as $userKey => $userValue) {
									?>
									<option value="<?php echo $userKey; ?>" <?php echo ($userKey==$userDocumentValue['user_id'])?"selected=selected":'' ?>><?php echo $userValue; ?></option>
									<?php
								} ?>
							</select>
						</td>
						<td>
							<select name="user_documents[<?php echo $userDocumentKey;?>][document_id]" id="document_id_<?php echo $userDocumentKey;?>" class="form-control select2 nochange viewInput" input-data-target ='document_<?php echo $userDocumentKey;?>' style="width:100%">
								<option value="">Select Document Type</option>
								<?php 
								foreach ($documents as $documentKey => $documentValue) {
									?>
									<option value="<?php echo $documentValue['id']; ?>" <?php echo ($documentValue['id']==$userDocumentValue['document_id'])?"selected=selected":'' ?>><?php echo $documentValue['name']; ?></option>
									<?php
								} ?>
							</select>
							<?//=$userDocumentValue['document_id'];?>
							<?//=(0!==$userDocumentValue['document_id'])?'none':'block'?>
							 <input type="text" name="user_documents[<?php echo $userDocumentKey;?>][input_document]" class="form-control input" id="document_<?php echo $userDocumentKey;?>" placeholder="Document Not found? Enter here" style="display: <?=(0!==$userDocumentValue['document_id'])?'none':'block'?>">
						</td>
						<td>
							<input type="file" name="user_documents[<?php echo $userDocumentKey; ?>][bg_image]" value="<?php echo $userDocumentValue['bg_image'];?>" id="bg_image_<?php echo $userDocumentKey; ?>">
							<input type="hidden" name="user_documents[<?php echo $userDocumentKey; ?>][bg_image2]" value="<?php echo $userDocumentValue['bg_image'];?>" id="bg_image2_<?php echo $userDocumentKey; ?>">
						
						</td>
						<td>
							<input type="file" name="user_documents[<?php echo $userDocumentKey; ?>][file]" value="<?php echo $userDocumentValue['file'];?>" id="file_<?php echo $userDocumentKey; ?>">
							<input type="hidden" name="user_documents[<?php echo $userDocumentKey; ?>][file2]" value="<?php echo $userDocumentValue['file'];?>" id="file2_<?php echo $userDocumentKey; ?>">
						
						</td>
						<td>
							<input type="text" name="user_documents[<?php echo $userDocumentKey; ?>][writeup]" value="<?=$userDocumentValue['writeup']?>" id="writeup_<?php echo $userDocumentKey; ?>" class="form-control" style="width: 200px">
						</td>
						<td>
							<input type="number" name="user_documents[<?php echo $userDocumentKey; ?>][priority]" value="<?=$userDocumentValue['priority']?>" id="priority_<?php echo $userDocumentKey; ?>" class="form-control" style="width: 100px">
						</td>
						<td>
							<input type="checkbox" name="user_documents[<?php echo $userDocumentKey; ?>][is_active]" value="true" id="is_active_<?php echo $userDocumentKey; ?>" class="flat-red" <?php if($userDocumentValue['is_active']){ echo "checked=checked";} ?>>
						</td>
						<td>
						<?php 
						if($userDocumentKey>0){ ?>
							<a href="#button" class="removebutton" data-id="<?php echo $userDocumentValue['id']; ?>" data-link="upload_documents/deactivate_document/<?php echo $userDocumentValue['id']; ?>"><span class="glyphicon glyphicon-trash"></span></a>
						<?php 
						} ?>
						</td>
					</tr>
					<?php
					}
					}else{ ?>
					<tr id="0">
						<td>
							<select name="user_documents[0][user_type]" id="user_type_0" class="form-control select2 filter nochange" data-target="user_id_0" data-link="upload_documents/type_wise_user" style="width:100%">
								<?php 
								foreach ($option['typeLists'] as $userTypeKey => $userTypeValue) {
									?>
									<option value="<?php echo $userTypeKey; ?>"><?php echo $userTypeValue; ?></option>
									<?php
								} ?>
							</select>
						</td>
						<td>
							<select name="user_documents[0][user_id]" id="user_id_0" class="form-control select2 nochange" style="width:100%">
								<?php 
								foreach ($users as $userKey => $userValue) {
									?>
									<option value="<?php echo $userKey; ?>"><?php echo $userValue; ?></option>
									<?php
								} ?>
							</select>
						</td>
						<td>
							<?php //print_r($documents); ?>
							<select name="user_documents[0][document_id]" id="document_id_0" class="form-control select2 nochange viewInput" input-data-target ='document_0' style="width:100%">
								<option value="">Select Document Type</option>
								<?php 
								foreach ($documents as $documentKey => $documentValue) {
									?>
									<option value="<?php echo $documentValue['id']; ?>"><?php echo $documentValue['name']; ?></option>
									<?php
								} ?>
							</select>
							 <input type="text" name="user_documents[0][input_document]" class="form-control input" id="document_0" placeholder="Document Not found? Enter here" >

						</td>
						<td>
							<input type="text" name="user_documents[0][writeup]" id="writeup_0" class="form-control" style="width: 200px">
						</td>
						<td>
							<input type="number" name="user_documents[0][priority]" id="priority_0" class="form-control" style="width: 100px">
						</td>
						<td>
							<input type="file" name="user_documents[0][bg_image]" id="bg_image_0">
						</td>
						<td>
							<input type="file" name="user_documents[0][file]" id="file_0">
						</td>
						<td><input type="checkbox" name="user_documents[0][is_active]" value="true" id="is_active_0" checked="checked"></td>
						<td></td>
					</tr>
				<?php } ?>
				</tbody>  
				<tfoot>
				   	<tr>
				   		<td colspan="7"><button type="button" id="AddMoreDocument" class="btn btn-info pull-right AddMoreRow">Add More</button>
				   		</td>
				   	</tr>
				</tfoot>
            </table>
			
			
			<!-- s --> <!-- /box-body -->  
	    </div>              
		<div class="box-footer">  
			<button type="submit" class="btn btn-info pull-left">Submit</button> &nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*echo nbs(3);*/ ?>
			<button type="submit" class="btn btn-info">cancel</button>
		</div>
		<!-- /.box-footer -->
	</div><!-- /box -->
	<?php echo form_close(); ?> 
</div>
