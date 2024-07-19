// public/js/custom-search.js

document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('sort');
    const searchForm = document.querySelector('form');

    function performSearch(page = 1) {
        const sortValue = sortSelect.value;
        const query = document.querySelector('input[name="query"]').value;

        fetch(`/products/search?sort=${sortValue}&query=${query}&page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                const productContainer = document.querySelector('.col-md-9 .row');
                productContainer.innerHTML = '';

                data.products.forEach(product => {
                    const productCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="/products/${product.id}">
                                <img src="${product.image}" class="card-img-top" alt="${product.name}">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">¥${product.price}</p>
                            </div>
                        </div>
                    </div>
                `;
                    productContainer.insertAdjacentHTML('beforeend', productCard);
                });

                // ページネーションリンクの更新
                const paginationContainer = document.querySelector('.d-flex.justify-content-center');
                paginationContainer.innerHTML = data.pagination;

                // ページネーションリンクにイベントリスナーを追加
                const paginationLinks = paginationContainer.querySelectorAll('a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const url = new URL(this.href);
                        const page = url.searchParams.get('page');
                        performSearch(page);
                    });
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // ソートセレクトボックス変更時に検索を実行
    sortSelect.addEventListener('change', function () {
        performSearch();
    });

    // 検索フォームサブミット時にページ番号をリセットして検索を実行
    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        performSearch();
    });
});
