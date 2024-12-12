var quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar'
    }
});

const imageInput = document.getElementById('image');

document.querySelector('.ql-image').addEventListener('click', function () {
    imageInput.click();
});
imageInput.addEventListener('change', function () {
    const file = imageInput.files[0];
    if (file) {
        //console.log(file);
        const reader = new FileReader();

        reader.onload = function (e) {
            const range = quill.getSelection();
            quill.insertEmbed(range.index, 'image', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

const explanation = document.getElementById('explanation');

let submitContent = () => {
    var textOnly = quill.getText();
    explanation.value = textOnly;
    alert(`teks yang akan dikirm :\n ${textOnly}`)
}

const fileInput = document.getElementById('file-upload');
const placeholderText = document.querySelector('.mt-2');

fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        placeholderText.textContent = fileInput.files[0].name;
    } else {
        placeholderText.textContent = 'No file selected';
    }
});