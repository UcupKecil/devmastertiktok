<script>
    let thisId;

    const transfer = (id) => {
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
            url: `/manage/history/${id}`,
            dataType: "json",
            success: function(data) {
                thisId = id;

                $('#transferForm').trigger('reset');

                $('#name').val(data.name)
                $('#point').val(data.point)

                $('#transferModal').modal('show');

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
                url: '/manage/history/table'
            },
            buttons: [],
            "columns": [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'waktu',
                    name: 'orders.created_at'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'sub_total',
                    name: 'orders.sub_total'
                },
                {
                    data: 'biaya_adm',
                    name: 'orders.biaya_adm'
                },
                {
                    data: 'total',
                    name: 'orders.total'
                },
                {
                    data: 'status',
                    name: 'orders.status'
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

        $('.price').keydown(function(e) {
            var key = e.charCode || e.keyCode || 0;

            return (
                key == 8 ||
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105)
            );
        }).keyup(function(event) {

            if (event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        $('#submitTransfer').click(function(e) {
            e.preventDefault();

            //var formData = $('#transferForm').serialize();
            var formData = new FormData($("#transferForm")[0]);

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
                url: `/manage/history/${thisId}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.close();

                    if (data.status) {
                        $('#transferModal').modal('hide');

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

