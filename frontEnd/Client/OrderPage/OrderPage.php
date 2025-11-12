<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/OMS/frontEnd/Client/OrderPage/OrderPage.css">
    <title>Document</title>
</head>
<body>
    <section class="appbar">
        <h2>Order Page</h2>
        <a href="/OMS/frontEnd/Client/Logout.php">🚪 Logout</a>
    </section>
    <section class="order-section">
        <div>
            <h1>Place Your Order at <?php echo htmlspecialchars($bakery_name); ?></h1>
            <h3>Add Customer Items</h3>
            <form action="" method="POST">
                <div id="item-container"> 
                    <div class="order-form item-row">
                        <button type="button" class="remove-button">🗑️</button> 
                        <div class="item-name item-info">
                            <label for="item_name_0">Item Name</label> 
                            <input type="text" id="item_name_0" name="item_name[]">
                        </div>
                        <div class="item-quantity item-info">
                            <label for="item_qty_0">Quantity</label>
                            <input type="number" id="item_qty_0" name="item_qty[]" min="1" value="1">
                        </div>
                    </div>
                </div>
                <button type="button" id="addButton" class="AddAnotherButton margineleft">Add Another Item</button>
                <button 
                    type="button" 
                    id="addButton" 
                    class="AddAnotherButton margineleft"
                    onClick="window.location.href='/OMS/BackEnd/ClientBackend/OrderStatusLogic.php?bakery_id=<?php echo urlencode($bakeryId); ?>';"
                    
                    >Open Orders Page</button>
                <button class="SubmitOrderButton margineleft">Submit Order</button>
            </form>
        </div>
        <div class="image-container">
            <img src="/OMS/frontEnd/Assets/Sweets.jpg" alt="Bakery Image" class="bakery-image">
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('addButton');
            const itemContainer = document.getElementById('item-container');
            let itemCount = 1;
            // --- 1. Function to handle removing an item row ---
            function removeItemRow(event) {
                // event.target is the clicked button.
                // .closest('.item-row') finds the nearest parent div with the class 'item-row'.
                const itemRowToRemove = event.target.closest('.item-row');
                
                // Safety check: ensure we don't remove the last item
                if (itemContainer.querySelectorAll('.item-row').length > 1) {
                    itemRowToRemove.remove();
                } else {
                    alert("You must order at least one item.");
                }
            }

            // --- 2. Attach click listener to the container (Event Delegation) ---
            // This listens for clicks on the 'itemContainer' but only runs the function
            // if the click originated on an element with the class 'remove-button'.
            itemContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-button')) {
                    removeItemRow(event);
                }
            });

            // --- 3. Add Another Item Button Logic ---
            addButton.addEventListener('click', function() {
                
                const templateRow = itemContainer.querySelector('.item-row');
                if (!templateRow) return;

                const newItemRow = templateRow.cloneNode(true); 

                // Clear values and update attributes in the new row
                const inputs = newItemRow.querySelectorAll('input');

                inputs.forEach(input => {
                    input.value = (input.type === 'number') ? 1 : ''; 

                    const baseId = input.id.replace(/\d+$/, ''); 
                    const newId = baseId + itemCount;
                    
                    input.id = newId;

                    const label = newItemRow.querySelector(`label[for^="${baseId}"]`);
                    if (label) {
                        label.setAttribute('for', newId);
                    }
                });

                // 4. Append the new row to the container
                itemContainer.appendChild(newItemRow);

                // 5. Increment counter
                itemCount++;
            });
        });
    </script>
</body>
</html>