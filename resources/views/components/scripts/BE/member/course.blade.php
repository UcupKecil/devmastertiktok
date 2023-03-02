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
                        `<video style="max-width: 740px;" class="container" 
                         controls  controlsList="nodownload" oncontextmenu="return false;" poster="/assets/images/courses/video/poster/${response.course_id}/${response.poster}">
                        <source src="/assets/videos/courses/${response.course_id}/${response.video}">
                    </video>`
                    );

                    
                }
            });

        });
    });
</script>
<!-- <script>
    // Disable right-click
document.addEventListener('contextmenu', (e) => e.preventDefault());

function ctrlShiftKey(e, keyCode) {
  return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
}

document.onkeydown = (e) => {
  // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
  if (
    event.keyCode === 123 ||
    ctrlShiftKey(e, 'I') ||
    ctrlShiftKey(e, 'J') ||
    ctrlShiftKey(e, 'C') ||
    (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
  )
    return false;
};
</script> -->

