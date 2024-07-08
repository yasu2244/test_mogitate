document.getElementById('image').addEventListener('change', function (e) {
    const fileInput = e.target;
    const fileNameElement = document.getElementById('fileName');
    const previewImage = document.getElementById('previewImage');

    // ファイル名の表示
    const fileName = fileInput.files[0].name;
    fileNameElement.textContent = fileName;
    fileNameElement.style.display = 'inline-block';

    // 画像プレビューの表示
    const reader = new FileReader();
    reader.onload = function (e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
    }
    reader.readAsDataURL(fileInput.files[0]);
});