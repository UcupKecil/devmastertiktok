<script>
    const id = {{ Auth::user()->id }};
    let level;
    let regency_id;
    let district_id;
    let village_id;
    // SECTION jquery ready
    const edit = () => {
        Swal.fire({
            title: 'Please Wait!',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            type: "GET",
            url: `/profil/${id}`,
            success: function (response) {
                $('#editForm').trigger('reset');

                level = response.occupation_level;
                regency_id = null;

                $('#id').val(id);
                $('#name').val(response.name);

                
                    $('#occupation_level').val(response.occupation_level);

                    var selectized = $('#province_id').selectize();

                    var control = selectized[0].selectize;

                    control.destroy();

                    var selectized = $('#regency_id').selectize();

                    var control = selectized[0].selectize;

                    control.destroy();

                    var selectized = $('#district_id').selectize();

                    var control = selectized[0].selectize;

                    control.destroy();

                    var selectized = $('#village_id').selectize();

                    var control = selectized[0].selectize;

                    control.destroy();

                    $('#province_id').html('');
                    $('#regency_id').html('');
                    $('#district_id').html('');
                    $('#village_id').html('');

                    $('#provinceLabel').text('Okupasi');
                    $('#regencyLabel').text('Okupasi');
                    $('#districtLabel').text('Okupasi');
                    $('#villageLabel').text('Okupasi');

                    $('#regencyDiv').hide();
                    $('#districtDiv').hide();
                    $('#villageDiv').hide();

                    if(level == 1) {
                        $.ajax({
                            type: "POST",
                            url: '/get/lokasi/1',
                            dataType: "JSON",
                            success: function (result) {
                                if(result.status) {
                                    $('#province_id').removeAttr("disabled");

                                    $.each(result.data, function(i, data) {
                                        $('#province_id').append(`
                                            <option value="${data.id}">${data.name}</option>
                                        `);
                                    });

                                    $('#province_id').selectize({
                                        sortField: 'text'
                                    });

                                    $('#province_id').data('selectize').setValue(response.occupation_id);
                                } else {
                                    $('#province_id').html('');
                                    $('#province_id').attr("disabled", "disabled");
                                }
                            }
                        });
                    } else if(level == 2) {
                        $('#provinceLabel').text('Provinsi');

                        regency_id = response.occupation_id;

                        $.ajax({
                            type: "POST",
                            url: '/get/lokasi/1',
                            data: {
                                'id': regency_id,
                                'level': 2
                            },
                            dataType: "JSON",
                            success: function (result) {
                                if(result.status) {
                                    $('#province_id').removeAttr("disabled");

                                    $.each(result.data, function(i, data) {
                                        $('#province_id').append(`
                                            <option value="${data.id}">${data.name}</option>
                                        `);
                                    });

                                    $('#province_id').selectize({
                                        sortField: 'text'
                                    });

                                    $('#province_id').data('selectize').setValue(result.id);
                                } else {
                                    $('#province_id').html('');
                                    $('#province_id').attr("disabled", "disabled");
                                }
                            }
                        });
                    } else if(level == 3) {
                        $('#provinceLabel').text('Provinsi');
                        $('#regencyLabel').text('Kota / Kabupaten');

                        district_id = response.occupation_id;

                        $.ajax({
                            type: "POST",
                            url: '/get/lokasi/1',
                            data: {
                                'id': district_id,
                                'level': 3
                            },
                            dataType: "JSON",
                            success: function (result) {
                                regency_id = result.regency_id;

                                if(result.status) {
                                    $('#province_id').removeAttr("disabled");

                                    $.each(result.data, function(i, data) {
                                        $('#province_id').append(`
                                            <option value="${data.id}">${data.name}</option>
                                        `);
                                    });

                                    $('#province_id').selectize({
                                        sortField: 'text'
                                    });

                                    $('#province_id').data('selectize').setValue(result.id);
                                } else {
                                    $('#province_id').html('');
                                    $('#province_id').attr("disabled", "disabled");
                                }
                            }
                        });
                    } else if(level == 4) {
                        $('#provinceLabel').text('Provinsi');
                        $('#regencyLabel').text('Kota / Kabupaten');
                        $('#districtLabel').text('Kecamatan');

                        village_id = response.occupation_id;

                        $.ajax({
                            type: "POST",
                            url: '/get/lokasi/1',
                            data: {
                                'id': village_id,
                                'level': 4
                            },
                            dataType: "JSON",
                            success: function (result) {
                                regency_id  = result.regency_id;
                                district_id = result.district_id;

                                if(result.status) {
                                    $('#province_id').removeAttr("disabled");

                                    $.each(result.data, function(i, data) {
                                        $('#province_id').append(`
                                            <option value="${data.id}">${data.name}</option>
                                        `);
                                    });

                                    $('#province_id').selectize({
                                        sortField: 'text'
                                    });

                                    $('#province_id').data('selectize').setValue(result.id);
                                } else {
                                    $('#province_id').html('');
                                    $('#province_id').attr("disabled", "disabled");
                                }
                            }
                        });
                    }
              

                swal.close();

                $('#validate').show();
                $('#submitEditData').hide();

                $('#editData').modal('show');
            }
        });
    }
    $(function() {
        // SECTION set CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        // !SECTION set CSRF token

        
            // SECTION ambil provinsi form edit
            $('#occupation_level').change(function (e) {
                e.preventDefault();

                level = $(this).val();

                Swal.fire({
                    title: 'Please Wait!',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                });

                $.ajax({
                    type: "POST",
                    url: '/get/lokasi/1',
                    dataType: "JSON",
                    success: function (response) {
                        regency_id = null;
                        district_id = null;

                        var selectized = $('#province_id').selectize();

                        var control = selectized[0].selectize;

                        control.destroy();

                        var selectized = $('#regency_id').selectize();

                        var control = selectized[0].selectize;

                        control.destroy();

                        var selectized = $('#district_id').selectize();

                        var control = selectized[0].selectize;

                        control.destroy();

                        var selectized = $('#village_id').selectize();

                        var control = selectized[0].selectize;

                        control.destroy();

                        $('#province_id').html('');
                        $('#regency_id').html('');
                        $('#district_id').html('');
                        $('#village_id').html('');

                        $('#provinceLabel').text('Okupasi');
                        $('#regencyLabel').text('Okupasi');
                        $('#districtLabel').text('Okupasi');
                        $('#villageLabel').text('Okupasi');

                        $('#regencyDiv').hide();
                        $('#districtDiv').hide();
                        $('#villageDiv').hide();

                        if(level == 1) {
                            $('#provinceLabel').text('Okupasi');
                        } else if(level == 2) {
                            $('#provinceLabel').text('Provinsi');
                            $('#regencyLabel').text('Okupasi');
                        } else if(level == 3) {
                            $('#provinceLabel').text('Provinsi');
                            $('#regencyLabel').text('Kota / Kabupaten');
                            $('#districtLabel').text('Okupasi');
                        } else if(level == 4) {
                            $('#provinceLabel').text('Provinsi');
                            $('#regencyLabel').text('Kota / Kabupaten');
                            $('#districtLabel').text('Kecamatan');
                        }

                        var selectized = $('#province_id').selectize();

                        var control = selectized[0].selectize;

                        control.destroy();

                        $('#province_id').html('');

                        if(response.status) {
                            $('#province_id').removeAttr("disabled");

                            $('#province_id').append(`
                                <option value="">Pilih</option>
                            `);

                            $.each(response.data, function(i, data) {
                                $('#province_id').append(`
                                    <option value="${data.id}">${data.name}</option>
                                `);
                            });

                            $('#province_id').selectize({
                                sortField: 'text'
                            });
                        } else {
                            $('#province_id').html('');
                            $('#province_id').attr("disabled", "disabled");
                        }

                        swal.close();
                    }
                });
            });
            // !SECTION ambil provinsi form edit
            // SECTION ambil kota / kabupaten form edit
            $('#province_id').change(function (e) {
                e.preventDefault();

                if(level > 1) {
                    Swal.fire({
                        title: 'Please Wait!',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: '/get/lokasi/2',
                        data: {
                            'id': $(this).val()
                        },
                        dataType: "JSON",
                        success: function (response) {
                            var selectized = $('#regency_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            var selectized = $('#district_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            var selectized = $('#village_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            $('#regency_id').html('');
                            $('#district_id').html('');
                            $('#village_id').html('');

                            if(response.status) {
                                $('#regencyDiv').show();

                                $('#regency_id').removeAttr("disabled");

                                $('#regency_id').append(`
                                    <option value="">Pilih</option>
                                `);

                                $.each(response.data, function(i, data) {
                                    $('#regency_id').append(`
                                        <option value="${data.id}">${data.name}</option>
                                    `);
                                });

                                $('#regency_id').selectize({
                                    sortField: 'text'
                                });

                                if(regency_id) {
                                    $('#regency_id').data('selectize').setValue(regency_id);
                                }
                            } else {
                                $('#regencyDiv').hide();
                                $('#regency_id').html('');
                                $('#regency_id').attr("disabled", "disabled");
                            }

                            swal.close();
                        }
                    });
                }

            });
            // !SECTION ambil kota / kabupaten form edit
            // SECTION ambil kecamatan form edit
            $('#regency_id').change(function (e) {
                e.preventDefault();

                if(level > 2) {
                    Swal.fire({
                        title: 'Please Wait!',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: '/get/lokasi/3',
                        data: {
                            'id': $(this).val()
                        },
                        dataType: "JSON",
                        success: function (response) {
                            var selectized = $('#district_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            var selectized = $('#village_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            $('#district_id').html('');
                            $('#village_id').html('');

                            if(response.status) {
                                $('#districtDiv').show();

                                $('#district_id').removeAttr("disabled");

                                $('#district_id').append(`
                                    <option value="">Pilih</option>
                                `);

                                $.each(response.data, function(i, data) {
                                    $('#district_id').append(`
                                        <option value="${data.id}">${data.name}</option>
                                    `);
                                });

                                $('#district_id').selectize({
                                    sortField: 'text'
                                });

                                if(district_id) {
                                    $('#district_id').data('selectize').setValue(district_id);
                                }
                            } else {
                                $('#districtDiv').hide();
                                $('#district_id').html('');
                                $('#district_id').attr("disabled", "disabled");
                            }

                            swal.close();
                        }
                    });
                }

            });
            // !SECTION ambil kecamatan form edit
            // SECTION ambil kelurahan form edit
            $('#district_id').change(function (e) {
                e.preventDefault();

                if(level == 4) {
                    Swal.fire({
                        title: 'Please Wait!',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    $.ajax({
                        type: "POST",
                        url: '/get/lokasi/4',
                        data: {
                            'id': $(this).val()
                        },
                        dataType: "JSON",
                        success: function (response) {
                            var selectized = $('#village_id').selectize();

                            var control = selectized[0].selectize;

                            control.destroy();

                            $('#village_id').html('');

                            if(response.status) {
                                $('#villageDiv').show();

                                $('#village_id').removeAttr("disabled");

                                $('#village_id').append(`
                                    <option value="">Pilih</option>
                                `);

                                $.each(response.data, function(i, data) {
                                    $('#village_id').append(`
                                        <option value="${data.id}">${data.name}</option>
                                    `);
                                });

                                $('#village_id').selectize({
                                    sortField: 'text'
                                });

                                if(village_id) {
                                    $('#village_id').data('selectize').setValue(village_id);
                                }
                            } else {
                                $('#villageDiv').hide();
                                $('#village_id').html('');
                                $('#village_id').attr("disabled", "disabled");
                            }

                            swal.close();
                        }
                    });
                }

            });
            // !SECTION ambil kelurahan form edit
    

        $('#validate').click(function (e) {
            e.preventDefault();

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
                url: "/validate/users/username/edit",
                data: {
                    id: $('#id').val(),
                    username: $('#username').val(),
                },
                dataType: "json",
                success: function (response) {
                    swal.close();

                    if (response.status) {
                        Swal.fire(
                            'Success!',
                            response.msg,
                            'success'
                        )

                        $('#validate').hide();
                        $('#submitEditData').show();

                    } else {
                        Swal.fire(
                            'Error!',
                            response.msg,
                            'warning'
                        )
                    }
                }
            });
        });

        // SECTION update Data
        $('#submitEditData').click(function(e) {
            e.preventDefault();

            const formData = new FormData($("#editDataForm")[0]);

            Swal.fire({
                title: 'Please Wait!',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                type: "POST",
                url: `/profil/edit/data`,
                data: formData,
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    swal.close();
                    if (data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        $("#labelName").text(data.data.name);

                        $('#editData').modal('hide');

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
        // !SECTION update Data

        // SECTION update Password
        $('#submitEditPassword').click(function(e) {
            e.preventDefault();

            const formData = new FormData($("#editPasswordForm")[0]);

            Swal.fire({
                title: 'Please Wait!',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                type: "POST",
                url: `/profil/edit/password`,
                data: formData,
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    swal.close();
                    if (data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        $('#editPassword').modal('hide');

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
        // !SECTION update Password
    });
    // !SECTION jquery ready
</script>
