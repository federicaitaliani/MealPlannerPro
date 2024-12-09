document.addEventListener("DOMContentLoaded", () => {
    const recipesContainer = document.getElementById("recipes-container");

    // Mock recipes data (replace with API fetch if needed)
    const recipes = [
        { id: 1, title: "Spaghetti Carbonara", ingredients: ["Spaghetti", "Eggs", "Pancetta"] },
        { id: 2, title: "Chicken Stir Fry", ingredients: ["Chicken", "Soy Sauce", "Broccoli"] },
    ];

    const shoppingList = JSON.parse(localStorage.getItem("shoppingList")) || [];

    // Dynamically render recipes
    recipes.forEach(recipe => {
        const recipeDiv = document.createElement("div");
        recipeDiv.className = "recipe";
        recipeDiv.innerHTML = `
            <h3>${recipe.title}</h3>
            <button class="add-button" data-id="${recipe.id}">Add Ingredients</button>
        `;
        recipesContainer.appendChild(recipeDiv);
    });

    // Add to shopping list
    document.querySelectorAll(".add-button").forEach(button => {
        button.addEventListener("click", () => {
            const recipeId = button.dataset.id;
            const selectedRecipe = recipes.find(r => r.id == recipeId);

            selectedRecipe.ingredients.forEach(ingredient => {
                if (!shoppingList.includes(ingredient)) {
                    shoppingList.push(ingredient);
                }
            });

            localStorage.setItem("shoppingList", JSON.stringify(shoppingList));
            alert(`${selectedRecipe.title} ingredients added to shopping list!`);
        });
    });

    // Navigate to shopping list page
    document.getElementById("view-shopping-list").addEventListener("click", () => {
        window.location.href = "shopping_list.html";
    });
});
