<script>
    // global app configuration object
    const config = {
        routes: {
            'loan-category': {
                'loan-category': "{{ route('loan-category') }}",
                'delete': "{{ route('loan-category.delete') }}",
                'status': "{{ route('loan-category.status') }}",
                'add': "{{ route('loan-category.add.edit') }}",
            },
        }
    };
</script>

<script>
    function openForm(module_type, id = '', from = '', dynamicModel = '', categoryId = '' ) {  
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: config.routes[module_type].add,
            type: 'POST',
            data: {id:id, from:from, dynamicModel:dynamicModel, categoryId:categoryId},
            success: function(res) {
                $( '#form-common-content' ).html(res);
                const drawerEl = document.querySelector("#kt_common_add_form");
                const commonDrawer = KTDrawer.getInstance(drawerEl);
                commonDrawer.show();
                return false;
            }, error: function(xhr,err){
                if( xhr.status == 403 ) {
                    toastr.error(xhr.statusText, 'UnAuthorized Access');
                }
            }
        });
    }

    function commonDelete(id, module_type) {
        Swal.fire({
            text: "Are you sure you would like to delete?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: config.routes[module_type].delete,
                    type: 'POST',
                    data: {id:id},
                    success: function(res) {
                        dtTable.ajax.reload();
                        Swal.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success",
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-success"
                            },
                            timer: 3000
                        });
                        
                    },
                    error: function(xhr,err){
                        if( xhr.status == 403 ) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });		
            }
        });
    }

    function commonChangeStatus(id, status, module_type) {
        Swal.fire({
            text: "Are you sure you would like to change status?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
               
                $.ajax({
                    url: config.routes[module_type].status,
                    type: 'POST',
                    data: {id:id, status:status},
                    success: function(res) {
                        dtTable.ajax.reload();
                        Swal.fire({
                            title: "Updated!",
                            text: res.message,
                            icon: "success",
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-success"
                            },
                            timer: 3000
                        });
                        
                    },
                    error: function(xhr,err){
                        if( xhr.status == 403 ) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });		
            }
        });
    }
    $(document).ready(function () {    
        $('.numberonly').keypress(function (e) {    
            var charCode = (e.which) ? e.which : event.keyCode    
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                return false;                        
        });    

    }); 

    $('.mobile_num').keypress(
        function(event) {
            if (event.keyCode == 46 || event.keyCode == 8) {
                //do nothing
            } else {
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        }
    );
</script>