<script>
    const deleteData = (id) => {
        Swal.fire({
            title: 'Apa anda yakin untuk menghapus data ini?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            swal.close();

            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Please Wait!',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                });

                if (result.value) {
                    $.ajax({
                        type: "delete",
                        url: `/manage/qna/${id}`,
                        dataType: "JSON",
                        success: function(response) {
                            swal.close();

                            if (response.status) {
                                Swal.fire(
                                    'Success!',
                                    response.msg,
                                    'success'
                                )

                                $('#table').DataTable().ajax.reload(null, false);
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.msg,
                                    'warning'
                                )
                            }
                        }
                    });
                }
            }
        });
    }

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#table').DataTable({
            order: [],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            filter: true,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {
                url: '/manage/qna/table'
            },
            buttons: [],
            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                
                
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        const reloadDatatable = () => {
            $('#table').DataTable().ajax.reload(null, false);
        };
    });
</script>
