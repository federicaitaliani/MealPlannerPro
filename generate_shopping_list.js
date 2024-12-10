async function fetchShoppingList() {
    const userId = 1; // Replace with dynamic user ID (e.g., from session)

    try {
        const response = await fetch('generate_shopping_list.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ user_id: userId })
        });
        const data = await response.json();

        const listElement = document.getElementById('shopping-list');
        listElement.innerHTML = ''; // Clear previous list

        if (data.success) {
            data.shoppingList.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                listElement.appendChild(li);
            });
        } else {
            listElement.innerHTML = `<li>${data.message}</li>`;
        }
    } catch (error) {
        console.error('Error fetching shopping list:', error);
    }
}

// Load shopping list on page load
document.addEventListener('DOMContentLoaded', fetchShoppingList);
