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
<script>
    function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}
    </script>