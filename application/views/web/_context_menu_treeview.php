<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
<?php if (!in_array($class,array(''))){ ?>
	<script type="text/javascript">
		$(function() {
	        $.contextMenu({
	            selector: '.node-treeview',
	            callback: function(key, options) {
	                var m = "clicked: " + key;
	                window.console && console.log(m); 
	            },
	            items: {
	        //     	"detail": {
	        //                     name: "Detail", 
	        //                     icon: "fas fa-file-alt",
	        //                     callback: function(key, options) {
									// var id = $(this).attr('id');
									// location.href = "<?= site_url($path . $class.'/detail') ?>/"+id;
					    //         }
	        //                 },
					"edit": {
								name: "Edit", 
								icon: "edit",
								callback: function(key, options) {
									var id = $(this).attr('id');
									location.href = "<?= site_url($path . $class.'/edit') ?>/"+id;
					            }
							},
					// "cut": {name: "Cut", icon: "cut"},
					// "copy": {name: "Copy", icon: "copy"},
					// "paste": {name: "Paste", icon: "paste"},
					// "delete": {
					// 			name: "Delete", 
					// 			icon: "delete",
					// 			callback: function(key, options){
					// 				var id = $(this).attr('id');
	    //                         	swal({   
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
	    //                         }
					// 			// callback: function(key, options) {
					// 			// 	if (confirm("Apakah anda yakin menghapus Unit Kerja ini ? ")){
					// 			// 		var id = $(this).attr('id');
					// 			// 		location.href = "<?php//= site_url($path . $class.'/delete') ?>/"+id;
					// 			// 	}
					//    //          }
					//         },
					"sep1": "---------",
	                "quit": {name: "Cancel", icon: function(){
	                    return 'context-menu-icon context-menu-icon-quit';
	                }}
	            }
	        });

	        $('.node-treeview').on('click', function(e){
	            console.log('clicked', this);
	        })    
	    });
	</script>
<?php } ?>