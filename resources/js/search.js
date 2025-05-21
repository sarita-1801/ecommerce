document.getElementById('searchInput').addEventListener('input', function () {
    let query = this.value;
    if (query.length > 2) {
        fetch(`/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let resultsContainer = document.getElementById('search-results');
                let searchResultsSection = document.getElementById('search-results-container');
                let allProductsSection = document.getElementById('all-products');

                // Show the search results container
                searchResultsSection.style.display = 'block';
                resultsContainer.innerHTML = '';

                // Hide the all-products section
                allProductsSection.style.display = 'none';

                // Populate products
                if (data.products.length > 0) {
                    data.products.forEach(product => {
                        let productCard = `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="/storage/${product.photo}" class="card-img-top" alt="${product.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">${product.detail}</p>
                                        <p class="card-text"><strong>Cost:</strong> $${product.cost}</p>
                                        <form action="/cart/add" method="POST">
                                            <input type="hidden" name="product_id" value="${product.id}">
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>`;
                        resultsContainer.innerHTML += productCard;
                    });
                }

                // Populate categories
                if (data.categories.length > 0) {
                    let categoryHeader = document.createElement('h5');
                    categoryHeader.innerText = 'Categories:';
                    resultsContainer.appendChild(categoryHeader);

                    data.categories.forEach(category => {
                        let categoryItem = `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">${category.title}</h5>
                                        <a href="/category/${category.id}" class="btn btn-primary">View Category</a>
                                    </div>
                                </div>
                            </div>`;
                        resultsContainer.innerHTML += categoryItem;
                    });
                }

                // If no results found
                if (data.products.length === 0 && data.categories.length === 0) {
                    resultsContainer.innerHTML = '<div class="text-muted">No results found</div>';
                }
            });
    } else {
        document.getElementById('search-results-container').style.display = 'none';
        document.getElementById('all-products').style.display = 'block';
    }
});
