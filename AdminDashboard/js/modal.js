// Open modal and populate the form with data from the table row (Product, User, and Category variants)
function openEditModal(button, type) {
    document.getElementById("editModal").style.display = "flex";
    
    // Get the parent row of the button
    const row = button.closest("tr");

    if (type === 'product') {
        // Retrieve and populate product data
        const productName = row.cells[1].textContent;
        const productDescription = row.cells[2].textContent;
        const productPrice = row.cells[3].textContent.replace("$", "");
        const productCategory = row.cells[4].textContent;
        const productQuantity = row.cells[5].textContent;
        const productStatus = row.cells[6].textContent;

        document.getElementById("productName").value = productName;
        document.getElementById("productDescription").value = productDescription;
        document.getElementById("productPrice").value = productPrice;
        document.getElementById("productCategory").value = productCategory;
        document.getElementById("productQuantity").value = productQuantity;
        document.getElementById("productStatus").value = productStatus.toLowerCase();
    } else if (type === 'user') {
        // Retrieve and populate user data
        const firstName = row.cells[1].textContent;
        const lastName = row.cells[2].textContent;
        const gender = row.cells[3].textContent;
        const birthDate = row.cells[4].textContent;
        const address = row.cells[5].textContent;
        const email = row.cells[6].textContent;
        const phone = row.cells[7].textContent;
        const role = row.cells[9].textContent;

        document.getElementById("firstName").value = firstName;
        document.getElementById("lastName").value = lastName;
        document.getElementById("gender").value = gender;
        document.getElementById("birthDate").value = birthDate;
        document.getElementById("address").value = address;
        document.getElementById("email").value = email;
        document.getElementById("phone").value = phone;
        document.getElementById("role").value = role;
    } else if (type === 'category') {
        // Retrieve and populate category data
        const categoryName = row.cells[1].textContent;
        const categoryDescription = row.cells[2].textContent;
        const categoryPicture = row.cells[3].querySelector('img').getAttribute('src');

        document.getElementById("categoryName").value = categoryName;
        document.getElementById("categoryDescription").value = categoryDescription;
        document.getElementById("categoryPicture").value = categoryPicture;
    }
}

// Close Edit Modal
function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

// Open Add Modal
function openAddModal(type) {
    if (type === 'category') {
        document.getElementById("addModalCategory").style.display = "flex";
    } else {
        document.getElementById("addModal").style.display = "flex";
    }
}

// Close Add Modal
function closeAddModal(type) {
    if (type === 'category') {
        document.getElementById("addModalCategory").style.display = "none";
    } else {
        document.getElementById("addModal").style.display = "none";
    }
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    const editModal = document.getElementById("editModal");
    const addModal = document.getElementById("addModal");
    const editModalCategory = document.getElementById("editModalCategory");
    const addModalCategory = document.getElementById("addModalCategory");

    if (event.target == editModal) {
        editModal.style.display = "none";
    } else if (event.target == addModal) {
        addModal.style.display = "none";
    } else if (event.target == editModalCategory) {
        editModalCategory.style.display = "none";
    } else if (event.target == addModalCategory) {
        addModalCategory.style.display = "none";
    }
}
