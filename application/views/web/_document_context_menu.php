<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>

<!-- Noti JS -->
	<link rel="stylesheet" href="<?= base_url('assets/web/plugins/noty-js/css/noty.css') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/web/plugins/noty-js/js/noty.min.js') ?>"></script>
<!-- End Noty JS -->

<script type="text/javascript">
	$(document).ready(function() {
        $.contextMenu({
            selector: '.clickable-row',
            callback: function(key, options) {
                var m = "clicked: " + key;
                window.console && console.log(m); 
            },
            items: {
            	"view": {
                            name: "Lihat File", 
                            icon: "fas fa-eye",
                            callback: function(key, options) {
								var id = $(this).attr('data-url');
								new Noty({
											type: 'alert',
											layout: 'bottomLeft',
											theme: 'sunset',
											text: 'Checking Document . . .',
											timeout: '1500',
											progressBar: true,
											killer: true,
											callbacks: {
												onClose: function() {
													$.ajax({
														url : '<?= site_url('web/document/ajaxGetFile') ?>/'+id,        
														type: "POST",
														data: {'with_user':true, 'log_text':'Melihat dokumen ini.', 'with_date':true},
														success: function(response){
															if (response==false){
																swal("View Failed","Dokumen tidak ada / Anda tidak mempunyai akses untuk melihat dokumen ini","error");
															} else {
																var file = JSON.parse(response);
																document.getElementById('contextmenu_view_document_modal_title').innerHTML = file.document_name;
																document.getElementById('viewed_document_by').innerHTML = file.user;
																document.getElementById('viewed_document_at').innerHTML = 'Tanggal '+file.date;
																document.getElementById("viewed_document_file").src = "https://docs.google.com/viewer?srcid="+file.file+"&pid=explorer&efh=false&a=v&chrome=false&embedded=true";
																$("#contextmenu_view_document_modal").modal('show');
															}
														}
													});
												}
										   },
										}).show();
				            }
                        },
            	"detail": {
                            name: "Detail", 
                            icon: "fas fa-info-circle",
                            callback: function(key, options) {
								var id = $(this).attr('data-url');
								location.href = "<?= site_url($path . $class.'/detail') ?>/"+id;
				            }
                        },
                /*
                	"download": {
                            name: "Download / Lihat File", 
                            icon: "fas fa-arrow-alt-circle-down",
                            callback: function(key, options) {
								var id = $(this).attr('data-url');
								new Noty({
											type: 'alert',
											layout: 'bottomLeft',
											theme: 'sunset',
											text: 'Checking Document . . .',
											timeout: '1500',
											progressBar: true,
											killer: true,
											callbacks: {
												onClose: function() {
													$.ajax({
														url : '<?= site_url('web/document/ajaxGetFile') ?>/'+id,        
														type: "POST",
														data: {},
														success: function(response){
															if (response==false){
																swal("Download Failed","Dokumen tidak ada / Anda tidak mempunyai akses untuk mendownload dokumen ini","error");
															} else {
																var file = JSON.parse(response);
																window.open(file.file, '_blank');
															}
														}
													});
												}
										   },
										}).show();
				            }
                        },
                */
                "sep1": "---------",
		    	<?php if (SessionManagerWeb::isAdministrator()) { ?>
					"edit": {
								name: "Edit", 
								icon: "edit",
								items:{
									"document_name" : {
										name:"Nama Dokumen",
										callback: function(key, options) {
											$("#contextmenu_edit_name_modal").modal('show');
							            }
							        },
							        "document_file" : {
										name:"File Dokumen",
										callback: function(key, options) {
											var id = $(this).attr('data-url');
											openModalEditFile(id);
							            }
							        },
								}
								
							},
						"sep2": "---------",
				<?php } ?>
				/*
					// // "cut": {name: "Cut", icon: "cut"},
					// // "copy": {name: "Copy", icon: "copy"},
					// // "paste": {name: "Paste", icon: "paste"},
					// "delete": {
					// 			name: "Delete", 
					// 			icon: "delete",
					// 			callback: function(key, options){
					// 				var id = $(this).attr('id');
	    			//				swal({   
					// 		            title: "Apakah anda yakin?",   
					// 		            text: "Struktur dibawahnya akan dihapus juga!",   
					// 		            type: "warning",   
					// 		            showCancelButton: true,   
					// 		            confirmButtonColor: "#26c6da",   
					// 		            confirmButtonText: "Ya, Lanjutkan",   
					// 		            cancelButtonText: "Tidak, Batalkan!",   
					// 		            closeOnConfirm: false,   
					// 		            closeOnCancel: false 
					// 		        }, function(isConfirm){   
					// 		            if (isConfirm) {
					// 		                // swal("Terhapus!", "Data ini berhasil dihapus.", "success");  
					// 		                location.href = "<?= site_url($path . $class.'/delete') ?>/"+id; 
					// 		            } else {     
					// 		                swal("Batal", "Proses penghapusan data dibatalkan.", "error");   
					// 		            } 
					// 		        });
	    			//           }
					// 			// callback: function(key, options) {
					// 			// 	if (confirm("Apakah anda yakin menghapus Unit Kerja ini ? ")){
					// 			// 		var id = $(this).attr('id');
					// 			// 		location.href = "<?php//= site_url($path . $class.'/delete') ?>/"+id;
					// 			// 	}
					//    //          }
					//         },
				*/
				
                "quit": {name: "Batal", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            },
            events: {
		       show : function(options){
				rowClick($(this));       
		       }
		   }
        }); 
    });
</script>

<!-- Modal Edit Name -->
	<div id="contextmenu_edit_name_modal" name="contextmenu_edit_name_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="contextmenu_edit_name_modal_title" aria-hidden="true" style="display: none;">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content card-outline-info">
	            <form id="form_edit" action="" method="POST">
	                <div class="modal-header card-header text-white">
	                    <h3 class="modal-title font-bold text-white" id="contextmenu_edit_name_modal_title">Edit Nama Dokumen</h3>
	                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body" id="contextmenu_edit_name_modal_body">
	                	<div class="row m-b-20">
	                        <div class="col-md-12">
	                            <div class="form-group m-b-0">
	                                <label for="contextmenu_edit_name">Deskripsi / Uraian / Nama </label>
	                                <div class="input-group">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text" id="basic-addon1">
	                                            <i class="mdi mdi-clipboard-text"></i>
	                                        </span>
	                                    </div>
	                                    <textarea rows="3" class="form-control" name="contextmenu_edit_name" id="contextmenu_edit_name" required></textarea>
	                                </div>
	                            </div>
	                            <small class="text-danger form-control-feedback hidden" id="error_contextmenu_edit_name">
	                                *cant be empty
	                            </small>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer" id="contextmenu_edit_name_modal_footer">
	                    <button type="button" id="contextmenu_edit_name_modal_submit" class="btn btn-success waves-effect text-left" document_id='' onClick="goUpdateName()"> 
	                        <i class="mdi mdi-check">
	                        </i> Update
	                    </button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<script type="text/javascript">
		function goUpdateName(){
			var validation = true;
			$("#error_contextmenu_edit_name").addClass("hidden");
            if (document.getElementById('contextmenu_edit_name').value==''){
                $("#error_contextmenu_edit_name").removeClass("hidden");
                validation = false;
            }

            if (validation){
            	var id = $("#contextmenu_edit_name_modal_submit").attr('document_id');
				$.ajax({
		            url : '<?= site_url('web/document/ajaxUpdate') ?>/'+id,        
		            type: "POST",
		            data: {'name' : document.getElementById('contextmenu_edit_name').value },
		            success: function(response){
		                if (response==false){
		                    var message = swal("Error!","Failed to Update, please try again later!","error");
		                } else {
		                    var message = swal("Updated!","Successfully update document.","success");
		                    message.then(function(){
		                        location.reload();
		                    });
		                }
		                
		            }
		        });
            }			
		}
	</script>
<!-- End Modal Edit Name -->

<!-- Modal Edit File -->
	<div id="contextmenu_edit_file_modal" name="contextmenu_edit_file_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="contextmenu_edit_file_modal_title" aria-hidden="true" style="display: none;">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content card-outline-info">
	        	<!-- TEMP VAR -->
	        		<!-- <input type="hidden" id="temp_document_id">
	        		<input type="hidden" id="temp_url">
	        		<input type="hidden" id="temp_file"> -->
	        	<!-- END TEMP VAR -->
	            <form id="form_edit_file" action="" method="POST">
	                <div class="modal-header card-header text-white">
	                    <h3 class="modal-title font-bold text-white" id="contextmenu_edit_file_modal_title">Edit File Dokumen</h3>
	                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
	                </div>
	                <div class="modal-body" id="contextmenu_edit_file_modal_body">
	                	<!-- <div class="row">
                            <div class="col-md-4">
                                <div class="switch">
                                    <label>
                                        <input type="checkbox" checked="" id="contextmenu_edit_file_type" name="contextmenu_edit_file_type" onchange="typeChanged()"><span class="lever"></span> <span class="font-bold text-danger"> Gunakan Link</span></label>
                                </div>
                            </div>
                        </div>
                        <hr /> -->
	                	<div class="row m-b-20">
	                        <div class="col-md-12">
	                            <div class="form-group m-b-0">
	                                <label for="contextmenu_edit_file">ID File di Google Drive </label>
	                                <div class="input-group">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text" id="basic-addon1">
	                                            <i class="mdi mdi-link-variant"></i>
	                                        </span>
	                                    </div>
	                                    <textarea rows="3" class="form-control" value="" name="contextmenu_edit_file" id="contextmenu_edit_file" required></textarea>
	                                </div>
	                            </div>
	                            <small class="text-danger form-control-feedback hidden" id="error_contextmenu_edit_file">
	                                *cant be empty
	                            </small>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer" id="contextmenu_edit_file_modal_footer">
	                    <button type="button" id="contextmenu_edit_file_modal_submit" class="btn btn-success waves-effect text-left" document_id='' onClick="goUpdateLink()"> 
	                        <i class="mdi mdi-check">
	                        </i> Update
	                    </button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<script type="text/javascript">

		function openModalEditFile(id){
			$.ajax({
				url : '<?= site_url('web/document/ajaxGetDocumentWithFile') ?>/'+id,        
				type: "POST",
				data: {},
				success: function(response){
					if (response!=false){
						var file = JSON.parse(response);
						// document.getElementById('temp_document_id').value = id;
						// document.getElementById('temp_url').value = file.file;
						// document.getElementById('temp_file').value = file.file_name+'.pdf';

						/* dont use this if local file */
							document.getElementById("contextmenu_edit_file").value = file.file;
						/* END dont use */
					}
					
					// document.getElementById("contextmenu_edit_file_type").checked = true;
					// typeChanged();

					$("#contextmenu_edit_file_modal").modal('show');
				}
			});
		}

		/*
			function typeChanged(){
				if (document.getElementById('contextmenu_edit_file_type').checked){
	                $("#contextmenu_edit_file").removeAttr("readonly");
	                document.getElementById("contextmenu_edit_file").value = document.getElementById('temp_url').value;
	            } else{
	            	document.getElementById("contextmenu_edit_file").value = document.getElementById('temp_file').value;
	                $("#contextmenu_edit_file").attr("readonly", true);
	            }
			}
		*/

		function goUpdateLink(){
			var validation = true;
			$("#error_contextmenu_edit_file").addClass("hidden");
            if (document.getElementById('contextmenu_edit_file').value==''){
                $("#error_contextmenu_edit_file").removeClass("hidden");
                validation = false;
            }

            if (validation){
            	var id = $("#contextmenu_edit_file_modal_submit").attr('document_id');
				$.ajax({
		            url : '<?= site_url('web/ajax/changeDocumentFile') ?>/'+id,        
		            type: "POST",
		            data: {'file' : document.getElementById('contextmenu_edit_file').value, 'type':'C' },
		            success: function(response){
		                if (response==false){
		                    var message = swal("Error!","Failed to Update, please try again later!","error");
		                } else {
		                    var message = swal("Updated!","Successfully update document.","success");
		                    message.then(function(){
		                        location.reload();
		                    });
		                }
		                
		            }
		        });
            }			
		}
	</script>
<!-- End Modal Edit File -->

<!-- Modal View Document -->
	<div id="contextmenu_view_document_modal" name="contextmenu_view_document_modal" class="modal fade bs-example-modal-lg p-0" tabindex="-1" role="dialog" aria-labelledby="contextmenu_view_document_modal_title" aria-hidden="true" style="display: none;">
	    <div class="modal-dialog modal-lg" style="max-width: 185vh">
	        <div class="modal-content card-outline-inverse" style="height:95vh;">
                <div class="modal-header card-header text-white">
                    <h5 class="modal-title font-bold text-white" id="contextmenu_view_document_modal_title">[Nama Dokumen]</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-0 " id="contextmenu_edit_name_modal_body">
                	<div class="row m-b-20">
                        <div class="col-md-12">
                        	<div style='background-color: #d1d1d1; height: 10vh; position: absolute; right: 1.7vh; top:0vh; width: 8vh;z-index: 2147483647;'> </div>
                        	<div class="text-center" style="position: absolute;top: 30vh;left: 65vh;opacity: 0.5;z-index: 214748366;"> 
								<h2>Diakses Oleh :</h2>
								<br />
								<h1 id="viewed_document_by">[NAME]</h1>
								<br />
								<br />
								<h1 id="viewed_document_at">Tanggal [TANGGAL]</h1>
                        	</div>
                        	<iframe id="viewed_document_file" src="" frameborder="0"  allowfullscreen width="100%" style="height:88vh"></iframe>
                        </div>
                    </div>
                </div>
	        </div>
	    </div>
	</div>
<!-- End Modal View Document -->