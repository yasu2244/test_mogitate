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
        const result = e.target.result;
        previewImage.src = result;
        previewImage.style.display = 'block';
        localStorage.setItem('imagePreview', result);
        localStorage.setItem('fileName', fileName);
    }
    reader.readAsDataURL(fileInput.files[0]);
});

// ページ読み込み時にローカルストレージから画像データを読み込み
document.addEventListener('DOMContentLoaded', function () {
    const storedImage = localStorage.getItem('imagePreview');
    const storedFileName = localStorage.getItem('fileName');
    if (storedImage && storedFileName) {
        const previewImage = document.getElementById('previewImage');
        const fileNameElement = document.getElementById('fileName');
        previewImage.src = storedImage;
        previewImage.style.display = 'block';
        fileNameElement.textContent = storedFileName;
        fileNameElement.style.display = 'inline-block';
    }
    // ページ移動時にローカルストレージをクリア
    window.addEventListener('beforeunload', function () {
        localStorage.removeItem('imagePreview');
        localStorage.removeItem('fileName');
    });
});
