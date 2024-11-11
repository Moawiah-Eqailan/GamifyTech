<?php
include("includes/header.php")
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Product dashboard</h1>

                    <div class="row">
                        <div>
                            <button type="button" class="button1"onclick="openAddModal()">
                                <span class="button__text">Add Product</span>
                                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                              </button>
                        </div>
                        <div class="pt-5 pb-3">
                            <h2>Product Table</h2>
                            <table class="responsive-table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Description</th>
                                        <th>Product Price</th>
                                        <th>Product Image</th>
                                        <th>Product Category</th>
                                        <th>Product Quantity</th>
                                        <th>Product Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Product Name">Widget A</td>
                                        <td data-label="Product Description">High-quality widget</td>
                                        <td data-label="Product Price">$10.00</td>
                                        <td data-label="Product Image"><img src="https://via.placeholder.com/50" alt="Product 1"></td>
                                        <td data-label="Product Category">Widgets</td>
                                        <td data-label="Product Quantity">100</td>
                                        <td data-label="Product Status">Instock</td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <button class="edit-btn" onclick="openEditModal(this)">Edit</button>
                                                <button class="delete-btn">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Product Name">Gadget B</td>
                                        <td data-label="Product Description">Premium gadget</td>
                                        <td data-label="Product Price">$20.00</td>
                                        <td data-label="Product Image"><img src="https://via.placeholder.com/50" alt="Product 2"></td>
                                        <td data-label="Product Category">Gadgets</td>
                                        <td data-label="Product Quantity">50</td>
                                        <td data-label="Product Status">Out of Stock</td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <button class="edit-btn" onclick="openEditModal(this)">Edit</button>
                                                <button class="delete-btn">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>              
                </div>
 <!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeEditModal()">X</button>
        <h2>Edit Product</h2>
        <form id="editForm">
            <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName"><br><br>
            </div>
            <div class="form-group">
            <label for="productDescription">Product Description:</label>
            <input type="text" id="productDescription" name="productDescription"><br><br>
            </div>
            <div class="form-group">
            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice"><br><br>
            </div>
            <div class="form-group">
            <label for="productCategory">Product Category:</label>
            <input type="text" id="productCategory" name="productCategory"><br><br>
        </div>
        <div class="form-group">
            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity"><br><br>
        </div>
        <div class="form-group">
            <label for="productStatus">Product Status:</label>
            <select id="productStatus" name="productStatus">
                <option value="instock">Instock</option>
                <option value="outofstock">Out of Stock</option>
            </select><br><br>
        </div>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeAddModal()">X</button>
        <h2>Add Product</h2>
        <form id="addForm">
          <div class="form-group"> 
            <label for="newProductName">Product Name:</label>
            <input type="text" id="newProductName" name="newProductName"><br><br>
          </div>
          <div class="form-group">
            <label for="newProductDescription">Product Description:</label>
            <input type="text" id="newProductDescription" name="newProductDescription"><br><br>
          </div> 
          <div class="form-group"> 
            <label for="newProductPrice">Product Price:</label>
            <input type="number" id="newProductPrice" name="newProductPrice"><br><br>
          </div>
          <div class="form-group">
            <label for="newProductCategory">Product Category:</label>
            <input type="text" id="newProductCategory" name="newProductCategory"><br><br>
        </div>
        <div class="form-group">      
            <label for="newProductQuantity">Product Quantity:</label>
            <input type="number" id="newProductQuantity" name="newProductQuantity"><br><br>
        </div>
        <div class="form-group">
            <label for="newProductStatus">Product Status:</label>
            <select id="newProductStatus" name="newProductStatus">
                <option value="instock">Instock</option>
                <option value="outofstock">Out of Stock</option>
            </select><br><br>
        </div>   
            <button type="submit">Add Product</button>
        </form>
    </div>
</div>
                      <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/modal.js"></script>

</body>

</html>