// cart

let cart = [];

function addToCart(itemName, itemPrice, itemQuantity) {
    let existingItem = cart.find(item => item.name === itemName);
    if (existingItem) {
        existingItem.quantity += itemQuantity;
    } else {
        cart.push({ name: itemName, price: itemPrice, quantity: itemQuantity });
    }
    updateCart();
    updateCartIcon();
    showPopupMessage(`${itemQuantity}x ${itemName} added to cart!`);
}

function updateCart() {
    const cartItems = document.getElementById("cart-items");
    const totalPriceElement = document.getElementById("total-price");
    cartItems.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        const listItem = document.createElement("li");
        listItem.innerHTML = `${item.name} - ₹${item.price * item.quantity} (${item.quantity}) `;
        
        const removeBtn = document.createElement("button");
        removeBtn.textContent = "Remove";
        removeBtn.onclick = function() { removeFromCart(index); };
        
        listItem.appendChild(removeBtn);
        cartItems.appendChild(listItem);
    });

    totalPriceElement.textContent = `Total: ₹${total}`;
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
    updateCartIcon();
}

function updateCartIcon() {
    const cartCount = document.getElementById("cart-count");
    let totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    if (totalQuantity > 0) {
        cartCount.style.display = "inline-block";
        cartCount.textContent = totalQuantity;
    } else {
        cartCount.style.display = "none"; // Hide count if cart is empty
    }
}

function showPopupMessage(message) {
    let popup = document.createElement("div");
    popup.innerText = message;
    popup.style.position = "fixed";
    popup.style.bottom = "20px";
    popup.style.right = "20px";
    popup.style.background = "green";
    popup.style.color = "white";
    popup.style.padding = "10px 20px";
    popup.style.borderRadius = "5px";
    popup.style.fontSize = "14px";
    popup.style.zIndex = "1000";
    popup.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.1)";
    
    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 2000);
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".menu_btn").forEach(button => {
        button.addEventListener("click", function () {
            const menuCard = this.closest(".menu_card");
            const itemName = menuCard.querySelector("h2").innerText;
            const itemPrice = parseInt(menuCard.querySelector(".price").innerText.replace("₹", ""));
            const itemQuantity = parseInt(menuCard.querySelector(".quantity-input").value);
            addToCart(itemName, itemPrice, itemQuantity);
        });
    });

    document.querySelector(".cart").addEventListener("click", function() {
        const cartBox = document.querySelector(".cart-box");
        cartBox.style.display = cartBox.style.display === "block" ? "none" : "block";
    });

    updateCartIcon();
});

// Quality buttons

    document.addEventListener("DOMContentLoaded", function () {
    // Select all quantity increment and decrement buttons
    document.querySelectorAll(".quantity-increment").forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.previousElementSibling; // Selects the input field before this button
            let value = parseInt(input.value);
            input.value = value + 1;
        });
    });

    document.querySelectorAll(".quantity-decrement").forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.nextElementSibling; // Selects the input field after this button
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
    });
});

