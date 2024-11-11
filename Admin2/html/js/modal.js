// Function to show a modal by ID
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "flex"; // Set display to 'flex' for centering
        document.querySelector(".top-navbar").style.display = "none"; // Hide navbar
    }
}

// Function to hide a modal by ID
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "none";
        document.querySelector(".top-navbar").style.display = "flex"; // Show navbar
    }
}

// General modal functions
function openModal(modalId) { showModal(modalId); }
function closeModal(modalId) { hideModal(modalId); }

// Open the view modal
function openViewModal() { showModal("viewModal"); }
function closeViewModal() { hideModal("viewModal"); }  // Close the view modal

// Open edit modal for a specific user ID
function openEditModal(userId) {
    const modalId = `editModal${userId}`; // Dynamically construct modal ID
    showModal(modalId);
}

// Close the edit modal for a specific user ID
function closeEditModal(userId) {
    const modalId = `editModal${userId}`;
    hideModal(modalId);
}

// Open edit modal for a specific coupon ID
function openEditCouponModal(couponId) {
    const modalId = `editModal${couponId}`; // Dynamically construct modal ID for each coupon
    showModal(modalId);
}

// Close the edit modal for a specific coupon ID
function closeEditCouponModal(couponId) {
    const modalId = `editModal${couponId}`;
    hideModal(modalId);
}

// Open and close the add modal
function openAddModal() { showModal("addModal"); }
function closeAddModal() { hideModal("addModal"); }

// Close button event listeners (closes modals with class 'close-btn' on click)
document.addEventListener("DOMContentLoaded", function () {
    const closeButtons = document.querySelectorAll(".close-btn");
    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            const modal = button.closest(".modal");
            if (modal) hideModal(modal.id);
        });
    });
});

// Close modal if user clicks outside modal content area
window.addEventListener("click", function(event) {
    const modals = document.querySelectorAll(".modal");
    modals.forEach(modal => {
        if (event.target === modal) hideModal(modal.id);
    });
});

// SweetAlert2 delete confirmation dialog
function confirmDelete(button) {
    const form = button.closest('form');
    const idInput = form.querySelector('input[name="deleteUserId"], input[name="category_id"], input[name="product_id"], input[name="coupon_id"]');
    const entityId = idInput ? idInput.value : null;

    if (!entityId) {
        console.warn("No ID found in the form.");
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "This item will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#db4f4f',
        cancelButtonColor: '#26c6da',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Form validation for editing a coupon or category
document.querySelectorAll('[id^="editForm"]').forEach(form => {
    form.addEventListener('submit', function(event) {
        const name = form.querySelector('input[name="coupon_name"]').value.trim();
        const discount = form.querySelector('input[name="coupon_discount"]').value.trim();
        const expiryDate = form.querySelector('input[name="coupon_expiry_date"]').value;

        if (!name || !discount || !expiryDate) {
            event.preventDefault();
            alert("Please fill in all required fields.");
        }
    });
});

// Form validation for adding a coupon or category
document.getElementById('addForm')?.addEventListener('submit', function(event) {
    const name = this.newCategoryName ? this.newCategoryName.value.trim() : this.coupon_name.value.trim();
    const description = this.newCategoryDescription ? this.newCategoryDescription.value.trim() : this.coupon_discount.value.trim();
    const expiryDate = this.coupon_expiry_date ? this.coupon_expiry_date.value : null;

    if (!name || (!description && !expiryDate)) {
        event.preventDefault();
        alert("Please fill in all required fields.");
    }
});

function openEditModal(categoryId) {
    document.getElementById('editModal' + categoryId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}