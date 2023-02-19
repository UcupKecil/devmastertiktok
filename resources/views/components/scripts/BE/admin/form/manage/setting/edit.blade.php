<script>
    $(function() {
        $('#image').dropify();
        $('#imagebanner').dropify();

        $('#detail').summernote({
            height: 300,
        });

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
    });
</script>
