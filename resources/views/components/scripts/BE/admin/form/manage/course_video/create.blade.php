<script>
    const loadVideo = file => new Promise((resolve, reject) => {
        try {
            let video = document.createElement('video')
            video.preload = 'metadata'

            video.onloadedmetadata = function() {
                resolve(this)
            }

            video.onerror = function() {
                reject("Invalid video. Please select a video file.")
            }

            video.src = window.URL.createObjectURL(file)
        } catch (e) {
            reject(e)
        }
    })

    const getDuration = async (e) => {
        const duration = await loadVideo(e.target.files[0]);

        $('#seconds').val(duration.duration)
    };

    $(function() {
        $('#poster').dropify();

        $('#detail').summernote({
            height: 300,
        });
    });
</script>
