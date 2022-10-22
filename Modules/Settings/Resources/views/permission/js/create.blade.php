<script>
    "use strict";
$(document).ready(function () {
    $('#addButton').on('click', function(){
        $('.modal-title').html('@lang('settings::label.permission.form.create_permission')');
        $('#name').removeClass('is-invalid');
        $('#error-name').html('');
        $('#error-role').html('');
        $('#data-form').trigger('reset');
        $('#modalForm').modal('show');
    });
    $('#data-form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            method:'POST',
            url:'{{ route("settings.permission.store") }}',
            data:new FormData(this),
            dataType:'JSON',
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(res){
                $('#saveButton').attr('disabled',true);
                $('#saveButton').html('@lang("label.button.process")');
                $('#name').removeClass('is-invalid');
                $('#error-name').html('');
                $('#error-role').html('');
            },
            success:function(res){
                $('#saveButton').attr('disabled',false);
                $('#saveButton').html('@lang("label.button.save")');
                if(res.result){
                    $('#modalForm').modal('hide');
                    datatable.draw();
                    Swal.fire({
                        text:res.message,
                        icon:"success",
                        buttonsStyling:!1,
                        confirmButtonText:"@lang('label.button.ok')",
                        customClass:{
                        confirmButton:"btn btn-primary"
                        }
                    });
                }else{
                    if(res.message.name){
                        $('#error-name').html(res.message.name[0]);
                        $('#name').addClass('is-invalid');
                    }
                    if(res.message.role){
                        $('#error-role').html(res.message.role[0]);
                    }
                }
            },
            error:function(xhr, status, error){
                $('#saveButton').attr('disabled',false);
                $('#saveButton').html('@lang("label.button.save")');
                var err = eval("(" + xhr.responseText + ")");
                Swal.fire({
                    text:err.message,
                    icon:"error",
                    buttonsStyling:!1,
                    confirmButtonText:"@lang('label.button.ok')",
                    customClass:{
                        confirmButton:"btn btn-primary"
                    }
                });
            }
        })
    });
})
</script>
