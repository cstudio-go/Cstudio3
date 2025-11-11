// upload.js

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    var fileInput = document.getElementById('fileUpload');
    var file = fileInput.files[0];

    if (file) {
        // Check if file size is under 2MB (2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size exceeds 2MB. Please select a smaller file.');
            e.preventDefault();  // Prevent form submission
        }
    }
});