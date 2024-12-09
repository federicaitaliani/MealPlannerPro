document.addEventListener("DOMContentLoaded", () => {
    const shoppingListElement = document.getElementById("shopping-list");
    const shoppingList = JSON.parse(localStorage.getItem("shoppingList")) || [];

    // Render shopping list
    shoppingList.forEach(item => {
        const listItem = document.createElement("li");
        listItem.textContent = item;
        shoppingListElement.appendChild(listItem);
    });

    // Clear shopping list
    document.getElementById("clear-list").addEventListener("click", () => {
        localStorage.removeItem("shoppingList");
        shoppingListElement.innerHTML = "";
        alert("Shopping list cleared!");
    });

    // Navigate back to meal planner
    document.getElementById("back-to-planner").addEventListener("click", () => {
        window.location.href = "meal_planner.html";
    });
});
