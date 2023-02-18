<script>
    const number_format = (number, decimals, dec_point, thousands_sep) => {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    $('#channel').change(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Please Wait!',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            },
        });

        const total = '{{ $course->price }}';

        $.ajax({
            type: "GET",
            url: "/tripay/fee/" + $(this).val() + '/' + total,
            dataType: "JSON",
            success: function(response) {
                $('#biaya_admin').val(response.fee);
                $('#biaya_adm').val('Rp. ' + number_format(response.fee, 0, ',',
                    ','));
                $('#grandTotal').text('Rp. ' + number_format(response.total, 0, ',', ','));

                swal.close();
            }
        });
    });
</script>
