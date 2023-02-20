<script>
    $(function() {
        const class_id = '{{ $valid->id }}';

        $('.video-card').click(function(e) {
            e.preventDefault();

            $('.video-card').removeClass('bg-warning');

            $(this).addClass('bg-warning');

            $.ajax({
                type: "get",
                url: `/mycourse/change-video/${class_id}/${$(this).data('id')}`,
                dataType: "json",
                success: function(response) {
                    $('#video').html('');

                    $('#video').append(
                        `<video style="width: 100%;
                            height: auto;" controls poster="/assets/images/courses/video/poster/${response.course_id}/${response.poster}">
                        <source src="/assets/videos/courses/${response.course_id}/${response.video}">
                    </video>`
                    );

                    
                }
            });

        });
    });
</script>
