function searchFood() {
    const query = document.getElementById('searchInput').value;
    fetch(`search.php?q=${query}`)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = '';
            data.forEach(food => {
                const foodElement = document.createElement('div');
                foodElement.textContent = food.name;
                resultsContainer.appendChild(foodElement);
            });
        })
        .catch(error => console.error('Error:', error));
}
