document.getElementById('image_uploader').addEventListener('change', function(event) {
    const imagePreview = document.getElementById('image_holder');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src =  e.target.result ;
        }
        reader.readAsDataURL(file);
    } else {
        imagePreview.innerHTML = '<span>No image selected</span>';
    }
   
});