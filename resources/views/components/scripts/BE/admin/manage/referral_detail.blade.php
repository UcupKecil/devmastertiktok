<script>
    let id = "{{ $id }}"

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
                        url: `/manage/referral/videos/${slug}/${id}`,
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

    const view = (id) => {
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
            url: `/manage/course/videos/${slug}/${id}`,
            dataType: "json",
            success: function(data) {

                $('#viewTitle').text(data.name);

                $('#viewBody').html('');

                $('#viewBody').append(
                    `<video width="320" height="240" controls poster="/assets/images/courses/video/poster/${data.course_id}/${data.poster}">
                        <source src="/assets/videos/courses/${data.course_id}/${data.video}">
                    </video>`
                );

                $('#viewDetail').html('');

                $('#viewDetail').html(data.detail);

                $('#viewModal').modal('show');

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
                url: `/manage/course/videos/${slug}/table`
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
                    data: 'section',
                    name: 'course_sections.name'
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
