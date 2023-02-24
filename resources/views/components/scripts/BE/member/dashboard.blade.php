<script>
    let text = document.getElementById('myReferral').innerHTML;

    const copy = async () => {
        try {
            await navigator.clipboard.writeText(text);

            alert('link refferal berhasil disalin');
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    }
</script>