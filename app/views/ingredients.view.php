<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Ingredients
    </title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .row {
            display: flex;
        }

        .col-md-4 {
            flex: 1;
            margin: 10px;
        }

        .dish-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        /* Additional styles for specific elements */
        ul.list-group {
            list-style-type: none;
            padding: 0;
        }

        form.ingredient-form {
            margin-top: 20px;
        }

        .dish-image {
            background-image: url("<?= ASSETS ?>/images/dishes/normaldish.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 5px;
        }

        #ing-form,
        #edit-button,
        #finish-button {
            display: none;
        }

        #edit-button,
        #finish-button {
            text-align: center;
            border-radius: 5px;
            margin: 10px;
            padding: 5px;
        }

        /* Style for pencil icon */
        .fa-pencil-square-o {
            cursor: pointer;
            /* Make the icon look clickable */
            color: #3498db;
            /* Change the color of the icon */
        }

        .fa-pencil-square-o:hover {
            color: #2980b9;
            /* Change the color of the icon on hover */
        }

        .fa-pencil-square-o:active {
            transform: scale(0.9);
            /* Scale the icon down slightly */
        }

        /* Style for the trash can icon */
        .fa-trash {
            cursor: pointer;
            /* Make the icon look clickable */
            color: #ff0000;
            /* Change the color of the icon */
        }

        /* Style for the trash can icon when hovered */
        .fa-trash:hover {
            color: #c0392b;
            /* Change the color of the icon on hover */
        }

        /* Style for the trash can icon when clicked */
        .fa-trash:active {
            transform: scale(0.9);
            /* Scale the icon down slightly */
        }

        /* Make extra table columns for edit icons be invisible */
        .edit-icons {
            display: none;
        }

        /* give blue glowing border */
        .rowinform {
            border: 3px solid #3498db;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
        }

    </style>
</head>

<body>


    <?php
    ?>
    <!-- Show all the dishes in a list -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Dishes</h3>
                <ul class="list-group">
                    <?php foreach ($dishes as $dish) : ?>
                        <li class="list-group-item">
                            <a href="#" data-id="<?= $dish->dish_id ?>" data-imgurl="<?= $dish->image_url ?>" class="dish-link">
                                <?= $dish->dish_name ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Dish details</h3>
                <div class="dish-image">
                    <img src="">
                </div>
                <div class="dish-info">
                    <h4 class="dish-name">
                        Select a dish to add ingredients
                    </h4>
                    <p class="dish-description"></p>
                </div>
                <!-- create a table for ingredients of dish -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="edit-icons"></th>
                            <th scope="col">Ingredient</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit</th>
                            <th scope="col" class="edit-icons"></th>
                        </tr>
                    </thead>
                    <tbody class="ingredients-list">
                    </tbody>
                </table>

                <a href=# class="btn btn-primary" id="edit-button">Edit Ingredients</a>
                <a href=# class="btn btn-primary" id="finish-button">Finish Editing</a>
            </div>


            <div class="col-md-4" id="ing-form">
                <h3>Add ingredient</h3>
                <form class="ingredient-form">
                    <div class="form-group">
                        <label for="ingredient">Ingredient</label>
                        <select id="ingredient" class="form-control" required>
                            <option value="" disabled selected>Select an ingredient</option>
                            <?php foreach ($ingredients as $ingredient) : ?>
                                <option value="<?= $ingredient->item_id ?>">
                                    <?= $ingredient->item_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step=0.001 id="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select id="unit" class="form-control" required>
                            <option value="" disabled selected>Select a unit</option>
                            <?php foreach ($units as $unit) : ?>
                                <option value="<?= $unit->unit_id ?>">
                                    <?= $unit->unit_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" id="add-button">Add ingredient</button>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    var dishes = <?php echo json_encode($dishes); ?>;
    var ingredientlist = <?php echo json_encode($ingredientlist); ?>;
    var ingredients = <?php echo json_encode($ingredients); ?>;
    var ingredientNames = {};
    ingredients.forEach(ingredient => {
        ingredientNames[ingredient.item_id] = ingredient
    });

    // console.log("ingredientNames")
    // console.log(ingredientNames);
    var units = <?php echo json_encode($units); ?>;
    var unitNames = {};
    units.forEach(unit => {
        unitNames[unit.unit_id] = unit
    });
    // console.log("unitNames")
    // console.log(unitNames);


    const dishLinks = document.querySelectorAll('.dish-link');
    const dishImage = document.querySelector('.dish-image');
    const dishName = document.querySelector('.dish-name');
    const dishIngredients = document.querySelector('.ingredients-list');

    const baseUrl = "<?= ASSETS ?>/images/dishes/";

    // Add event listeners to all the dish links to show the dish details and change the image and list all it's ingredients
    dishLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();


            // make the form and  edit button visible
            document.getElementById("ing-form").style.display = "block";
            document.getElementById("edit-button").style.display = "block";



            clearForm();
            makeNonEditable();

            const id = link.getAttribute('data-id');
            // set the dish id in the form
            document.querySelector('.ingredient-form').setAttribute('data-dish-id', id);
            const imgname = link.getAttribute('data-imgurl');
            const imageUrl = baseUrl + imgname;
            dishImage.style.backgroundImage = `url(${imageUrl})`;
            dishName.textContent = dishes[id].dish_name;

            // get the ingredients of the dish
            myingredients = ingredientlist[id];

            // display all the ingredients of the dish below the image in the table
            dishIngredients.innerHTML = "";

            // if no ingredients are added yet
            if (!myingredients) {
                dishIngredients.innerHTML = `
                    <tr>
                        <td colspan="5">No ingredients added yet</td>
                    </tr>
                `;
            } else {
                myingredients.forEach(ingredient => {
                    // console.log(ingredient);
                    dishIngredients.innerHTML += `
                        <tr>
                            <td style="display:none"> <i class = "fa fa-pencil-square-o" aria-hidden="true"></i></td>
                            <td data-ing-id = "${ingredient.item_id}" >${ingredient.item_name}</td>
                            <td>${ingredient.quantity}</td>
                            <td data-unit-id ="${ingredient.unit}">${unitNames[ingredient.unit].unit_name}</td>
                            <td style="display:none"> <i class="fa fa-trash trash-icon"></i> </td>
                        </tr>
                    `;
                });

                // Add event listener to all edit icons to edit the ingredient
                editOnClick();

                // Add event listener to all trash icons to delete the ingredient
                DeleteOnTrashClick();
            }
        });
    });

    // Add event listener to the form to add a new ingredient or update dish
    document.querySelector("#add-button").addEventListener("click", function(event) {

        event.preventDefault();

        var dish = document.querySelector(".ingredient-form").getAttribute("data-dish-id");
        var ingredient = document.getElementById("ingredient").value;
        var quantity = document.getElementById("quantity").value;
        var unit = document.getElementById("unit").value;

        var data = {
            dish: dish,
            ingredient: ingredient,
            quantity: quantity,
            unit: unit
        };


        // check whether button is used for submitting form or updating
        if (event.target.textContent == "Add") {

            event.preventDefault();

            // console.log("Adding below");
            // console.log(data);

            fetch("<?= ROOT ?>/admin/ingredients/add", {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error("Error:", error);
                });


            // add the ingredient to the table below the image

            // if the table is empty, remove the "no ingredients added yet" row
            if (dishIngredients.innerHTML == `
                    <tr>
                        <td colspan="5">No ingredients added yet</td>
                    </tr>
                `) {
                dishIngredients.innerHTML = "";
            } else {
                // if the table is not empty, add the ingredient to the table
                const tbody = document.querySelector(".ingredients-list");
                let ingid = document.getElementById("ingredient").value;
                let unitid = document.getElementById("unit").value;
                const tr = document.createElement("tr");

                // create cells for pencil icon
                const pencilCell = document.createElement("td");
                pencilCell.innerHTML = `<i class = "fa fa-pencil-square-o" aria-hidden="true" ></i>`;
                tr.appendChild(pencilCell);

                const ingredientCell = document.createElement("td");
                ingredientCell.textContent = ingredientNames[ingid].item_name;
                tr.appendChild(ingredientCell);

                const quantityCell = document.createElement("td");
                quantityCell.textContent = quantity;
                tr.appendChild(quantityCell);

                const unitCell = document.createElement("td");
                unitCell.textContent = unitNames[unitid].unit_name;
                tr.appendChild(unitCell);

                // create cells for trash icon
                const trashCell = document.createElement("td");
                trashCell.innerHTML = `<i class="fa fa-trash trash-icon" ></i>`;
                tr.appendChild(trashCell);

                // add the table row to the table
                tbody.appendChild(tr);

                DeleteOnTrashClick(tr);
                editOnClick(tr);

                // hide the pencil and trash icons
                pencilCell.style.display = "none";
                trashCell.style.display = "none";

                ingredientCell.setAttribute('data-ing-id', data.ingredient);
                unitCell.setAttribute('data-unit-id', unitid);

                clearForm();
                // makeNonEditable();
            }
        } else if (event.target.textContent == "Save") {

            // send the data to the server to delete the ingredient from the dish
            fetch("<?= ROOT ?>/admin/ingredients/edit", {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            clearForm();

            // change the table row to the new values
            var tablerow = document.querySelector(".rowinform");
            tablerow.children[1].textContent = ingredientNames[ingredient].item_name;
            tablerow.children[2].textContent = quantity;
            tablerow.children[3].textContent = unitNames[unit].unit_name;

            RowinForm();
        }
    });

    // Add event listener to the add button to make the ingredients non editable and submit the form
    document.getElementById("finish-button").addEventListener("click", function(event) {
        // event.preventDefault();
        makeNonEditable();
    });

    // Add event listener to the edit button to make the ingredients editable
    document.getElementById("edit-button").addEventListener("click", function(event) {
        event.preventDefault();
        makeEditable();
        // make form field ingredient non editable
        document.getElementById("ingredient").disabled = true;
    });

    function makeEditable() {
        // Make the table headers with class edit-icons visible
        const editIcons = document.querySelectorAll('.edit-icons');
        editIcons.forEach(editIcon => {
            editIcon.style.display = "block";
        });

        // make finish button visible
        document.getElementById("finish-button").style.display = "block";

        // make trash icon visible
        const trashIcons = document.querySelectorAll('.ingredients-list .trash-icon');
        trashIcons.forEach(trashIcon => {
            trashIcon.parentElement.style.display = "block";
        });

        // make the pencil icon visible
        const pencilIcons = document.querySelectorAll('.ingredients-list .fa-pencil-square-o');
        pencilIcons.forEach(pencilIcon => {
            pencilIcon.parentElement.style.display = "block";
        });

        // make the edit button invisible
        document.getElementById("edit-button").style.display = "none";

        // make the add ingredient button say save
        document.getElementById("add-button").textContent = "Save";

    }

    function makeNonEditable() {
        // Make the table headers with class edit-icons invisible
        const editIcons = document.querySelectorAll('.edit-icons');
        editIcons.forEach(editIcon => {
            editIcon.style.display = "none";
        });

        // make ingredient field editable
        document.getElementById("ingredient").disabled = false;

        // make finish button invisible
        document.getElementById("finish-button").style.display = "none";

        // make trash icon invisible
        const trashIcons = document.querySelectorAll('.ingredients-list .trash-icon');
        trashIcons.forEach(trashIcon => {
            trashIcon.parentElement.style.display = "none";
        });

        // make the pencil icon invisible
        const pencilIcons = document.querySelectorAll('.ingredients-list .fa-pencil-square-o');
        pencilIcons.forEach(pencilIcon => {
            pencilIcon.parentElement.style.display = "none";
        });

        // make the edit button visible
        document.getElementById("edit-button").style.display = "block";

        // make the add ingredient button say add
        document.getElementById("add-button").textContent = "Add";

    }

    // Add event listener to all trash icons to delete the ingredient
    // If an object is passed only the trash icons in that object are added
    function DeleteOnTrashClick(something = null) {

        if (!something)
            var tcicons = document.querySelectorAll(".trash-icon")
        else
            var tcicons = something.querySelectorAll(".trash-icon")

        tcicons.forEach(tcicon => {

            tcicon.addEventListener("click", function(event) {
                event.preventDefault();
                // get the ingredient id and dish id
                var ingredient = event.target.parentElement.parentElement.children[1].getAttribute("data-ing-id");
                var dish = document.querySelector(".ingredient-form").getAttribute("data-dish-id");
                ingredient = ingredientNames[ingredient].item_id;
                var data = {
                    dish: dish,
                    ingredient: ingredient
                };

                // send the data to the server to delete the ingredient from the dish
                fetch("<?= ROOT ?>/admin/ingredients/delete", {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });

                // remove the ingredient from the table
                event.target.parentElement.parentElement.remove();
                clearForm();
            })
        });
    }

    function clearForm() {
        document.getElementById("ingredient").value = "";
        document.getElementById("quantity").value = "";
        document.getElementById("unit").value = "";
    }

    // Add event listener to all pencil icons to edit the ingredient
    // Fills in the form with the ingredient data
    // If an object is passed only the edit icons in that object are added

    function editOnClick(something = null) {
        if (!something)
            var pencilIcons = document.querySelectorAll('.ingredients-list .fa-pencil-square-o');
        else
            var pencilIcons = something.querySelectorAll('.fa-pencil-square-o');

        pencilIcons.forEach(pencilIcon => {
            pencilIcon.addEventListener("click", function(event) {
                event.preventDefault();

                // get the row that is being edited
                let tablerow = event.target.parentElement.parentElement;
                // get the ingredient id, dish id, unit id and quantity
                var dish = document.querySelector(".ingredient-form").getAttribute("data-dish-id");
                var ingredient = tablerow.children[1].getAttribute("data-ing-id");
                var quantity = tablerow.children[2].textContent;
                var unitid = tablerow.children[3].getAttribute("data-unit-id");

                // highlight the row that is being edited
                RowinForm(tablerow);

                // autofill the form with the ingredient data
                document.getElementById("ingredient").value = ingredient
                document.getElementById("quantity").value = quantity
                document.getElementById("unit").value = unitid
                document.getElementById("quantity").value = quantity

                // focus on the form
                document.getElementById("ingredient").focus();
            })
        });
    }

    // Highlight the row that is being edited
    function RowinForm(row = null) {
        // remove the rowinform class from all rows
        const rows = document.querySelectorAll(".rowinform");
        rows.forEach(row => {
            row.classList.remove("rowinform");
        });

        // add the rowinform class to the row that is being edited
        if (row)
            row.classList.add("rowinform");
    }
</script>



</html>

<?php include "partials/dashboard.footer.php" ?>