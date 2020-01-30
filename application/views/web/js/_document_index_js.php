<script type="text/javascript">
    $(document).ready(function(){
        $(".clickable-row").click(function() {
            rowClick($(this));
        });

        $(".custom-right-side-toggle").click(function () {
            if (window.screen.availWidth>=576){
                if ($("#content_right").hasClass("hidden")){
                    $("#content").removeClass("col-lg-12");
                    $("#content").addClass("col-lg-8");
                    $("#content_right").removeClass("hidden");
                    $(".custom-right-side-toggle").removeClass("btn-secondary");
                    $(".custom-right-side-toggle").addClass("btn-info");
                } else {
                    $("#content").addClass("col-lg-12");
                    $("#content").removeClass("col-lg-8");
                    $("#content_right").addClass("hidden");
                    $(".custom-right-side-toggle").addClass("btn-secondary");
                    $(".custom-right-side-toggle").removeClass("btn-info");
                }
            } else {
                $(".right-sidebar").slideDown(50);
                $(".right-sidebar").toggleClass("shw-rside");
                if ($(".right-sidebar").hasClass("shw-rside")){
                    $(".custom-right-side-toggle").removeClass("btn-secondary");
                    $(".custom-right-side-toggle").addClass("btn-info");
                } else {
                    $(".custom-right-side-toggle").addClass("btn-secondary");
                    $(".custom-right-side-toggle").removeClass("btn-info");
                }
            }
        });
    });

    function rowClick(elements){
        $(".custom-right-side-toggle").removeClass("hidden");

        var document_id = elements.data("url");
        $("#contextmenu_edit_name_modal_submit").attr('document_id', document_id);
        $("#contextmenu_edit_file_modal_submit").attr('document_id', document_id);
        var table = document.getElementById('table_document');
        var size = table.rows.length;
        for(var i=0;i<size;i++){
            // if(i%2==0){
            //     $("#tr_"+i).css('background-color','#f8f8f8');   
            // }else{
            //     $("#tr_"+i).css('background-color','#fff');  
            // }    

            $("#tr_"+i).removeClass("table-info");
        }
        // elements.css('background-color','#c0d9f9');
        elements.addClass("table-info");

        $("#content_right").block({
            message: '<i class="fas fa-spin fa-sync text-white"></i>',
            fadeIn: 1000,
            // timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.5,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                color: '#333',
                backgroundColor: 'transparent'
            },
            onBlock: function() {
                $.ajax({
                    url : '<?= site_url('web/ajax/getDocument') ?>/'+document_id,        
                    type: "POST",
                    data: {},
                    success: function(response){
                        /* Reset Detail */
                            document.getElementById('doc_info_name').innerHTML = '[Nama Dokumen]';
                            document.getElementById('doc_info_folder_name').innerHTML = '[Folder Name]';
                            document.getElementById('doc_info_archive_number').innerHTML = '[Archive Number]';
                            document.getElementById('doc_info_file_name').innerHTML = '[File Name]';
                            document.getElementById('doc_info_classification_code').innerHTML = '[Classification Code]';
                            document.getElementById('doc_info_workunit_name').innerHTML = '[Workunit Name]';
                            document.getElementById('doc_info_year').innerHTML = '[Year]';
                            document.getElementById('doc_info_location_code').innerHTML = '[Location]';
                            document.getElementById('doc_info_block_code').innerHTML = '[Block]';
                            document.getElementById('doc_info_rack_code').innerHTML = '[Rack]';
                            document.getElementById('doc_info_envelope_code').innerHTML = '[Envelope]';
                            document.getElementById('doc_info_box_code').innerHTML = '[Box]';
                            document.getElementById('doc_info_condition').innerHTML = '[Condition]';
                        /* End Reset Detail */

                        /* Reset History*/
                            $("#doc_info_div_history").addClass("m-l-10");
                            document.getElementById('doc_info_div_history').innerHTML = 
                                `<div class="sl-item m-b-0">
                                    <div class="text-center">
                                        <strong class="font-bold force-font-13">No History Found</strong>
                                    </div>
                                </div>
                                <hr>
                                `;
                        /* End Reset History*/

                        /* Reset History*/
                            $("#doc_info_div_activity").addClass("m-l-10");
                            document.getElementById('doc_info_div_activity').innerHTML = 
                                `<div class="sl-item m-b-0">
                                    <div class="text-center">
                                        <strong class="font-bold force-font-13">No Activity Found</strong>
                                    </div>
                                </div>
                                <hr>
                                `;
                        /* End Reset History*/

                        if (response==false){
                            console.log('error');
                        } else {
                            var data = JSON.parse(response);
                            // console.log(data);
                            /* Set Detail */
                                if (data['document']!=false){
                                    document.getElementById('doc_info_name').innerHTML = data['document'].name;
                                    document.getElementById('doc_info_folder_name').innerHTML = data['document'].folder_name;
                                    document.getElementById('doc_info_archive_number').innerHTML = data['document'].archive_number;
                                    document.getElementById('doc_info_file_name').innerHTML = data['document'].file_name;
                                    document.getElementById('doc_info_classification_code').innerHTML = data['document'].classification_code;
                                    document.getElementById('doc_info_workunit_name').innerHTML = data['document'].workunit_name;
                                    document.getElementById('doc_info_year').innerHTML = data['document'].year;
                                    document.getElementById('doc_info_location_code').innerHTML = data['document'].location_code;
                                    document.getElementById('doc_info_block_code').innerHTML = data['document'].block_code;
                                    document.getElementById('doc_info_rack_code').innerHTML = data['document'].rack_code;
                                    document.getElementById('doc_info_envelope_code').innerHTML = data['document'].envelope_code;
                                    document.getElementById('doc_info_box_code').innerHTML = data['document'].box_code;
                                    document.getElementById('doc_info_condition').innerHTML = data['document'].condition;
                                }
                                
                            /* End Set Detail */
                            

                            /* Set Activity */
                                if (data['history']!=false){
                                    $("#doc_info_div_history").removeClass("m-l-10");
                                    document.getElementById('doc_info_div_history').innerHTML = '';
                                    data['history'].forEach(function(item, index){
                                        document.getElementById('doc_info_div_history').innerHTML += 
                                            `<div class="sl-item m-b-0">
                                                <div class="sl-left"> <img src="<?= base_url('assets/uploads/users/photos/nopic.png') ?>" alt="User" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <strong class="font-bold">`+item.user_name+`</strong>
                                                        <br> 
                                                        <span class="sl-date force-font-11">`+item.datetime+`</span>
                                                        <p class="force-font-13 m-b-0">`+item.text+`</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>`;
                                    });
                                }
                                
                            /* End Set Activity */

                            /* Set Detail */
                                if (data['activity']!=false){
                                    $("#doc_info_div_activity").removeClass("m-l-10");
                                    document.getElementById('doc_info_div_activity').innerHTML = '';
                                    data['activity'].forEach(function(item, index){
                                        document.getElementById('doc_info_div_activity').innerHTML += 
                                            `<div class="sl-item m-b-0">
                                                <div class="sl-left"> <img src="<?= base_url('assets/uploads/users/photos/nopic.png') ?>" alt="User" class="img-circle"> </div>
                                                <div class="sl-right">
                                                    <div>
                                                        <strong class="font-bold">`+item.user_name+`</strong>
                                                        <br> 
                                                        <span class="sl-date force-font-11">`+item.datetime+`</span>
                                                        <p class="force-font-13 m-b-0">`+item.text+`</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>`;
                                    });
                                }
                            /* End Set Detail */

                            /* CONTEXT MENU EDIT */
                                /* Document Name */
                                    document.getElementById("contextmenu_edit_name").value = data['document'].name;
                                    document.getElementById("contextmenu_edit_name").innerHTML = data['document'].name;
                                /* End Document Name */ 

                                /* Code Variables */

                                /* End Code Variables */ 
                            /* End CONTEXT MENU EDIT */
                        }
                        $("#content_right").unblock();
                    }
                });
            }
        });
    }
</script>