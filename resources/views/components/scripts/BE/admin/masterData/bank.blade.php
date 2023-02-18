<script>
    let thisId;

    const create = () => {
        $('#createForm').trigger('reset');
        $('#createModal').modal('show');
    }

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
                        url: `/master-data/bank/${id}`,
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

    const edit = (id) => {
        Swal.fire({
            title: 'Please Wait!',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            type: "get",
            url: `/master-data/bank/${id}`,
            dataType: "json",
            success: function(data) {
                thisId = id;

                $('#editForm').trigger('reset');

                $('#name').val(data.name)

                $('#editModal').modal('show');

                swal.close();
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
                url: '/master-data/bank/table'
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

        $('#submitCreate').click(function(e) {
            e.preventDefault();

            var formData = $('#createForm').serialize();

            Swal.fire({
                title: 'Please Wait!',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                type: "post",
                url: "/master-data/bank",
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data) {
                    swal.close();

                    if (data.status) {
                        $('#createModal').modal('hide');

                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        reloadDatatable();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'warning'
                        );
                    }
                }
            });
        });

        $('#submitEdit').click(function(e) {
            e.preventDefault();

            var formData = $('#editForm').serialize();

            Swal.fire({
                title: 'Please Wait!',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                type: "post",
                url: `/master-data/bank/${thisId}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data) {
                    swal.close();

                    if (data.status) {
                        $('#editModal').modal('hide');

                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        thisId = null;

                        reloadDatatable();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'warning'
                        )
                    }
                }
            });
        });
    });
</script>
