function fetchProductDetails(productId) {
    $.ajax({
      url: './../../controllers/get_products.php',
      method: 'GET',
      dataType: 'json', 
      data: { id: productId },
      success: function (response) {
        console.log(response); 
  
        if (response.success && Array.isArray(response.data)) {
          const product = response.data.find(p => p.id == productId);
          if (product) {
            $('#product_name').val(product.name);
            $('#price').val(product.price);
            $('#category').val(product.category_id);
            $('#description').val(product.description);
  
            if (product.image_url) {
              $('#image-preview').attr('src', '../../' + product.image_url).show();
              $('#preview-icon').hide();
              $('#upload-text').hide();
            }
          } else {
            alert('Product not found.');
          }
        } else {
          alert('Failed to fetch product details.');
        }
      },
      error: function () {
        alert('An error occurred while fetching product details.');
      }
    });
  }
  
        function fetchCategories() {
     $.ajax({
       url: './../../controllers/get_categories.php',
       method: 'GET',
       dataType: 'json',
       success: function (response) {
         console.log(response);  
         if (response.length > 0) {
           const categoryDropdown = $('#category');
           categoryDropdown.empty();
           response.forEach(function (category) {
             var c_name = category.name.replace(/\b\w/g, char => char.toUpperCase());  
             categoryDropdown.append(`<option value="${category.id}">${c_name}</option>`);
           });
         } else {
           alert('No categories found.');
         }
       },
       error: function () {
         alert('An error occurred while fetching categories.');
       },
     });
  }
  
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');
  
        if (productId) {
          fetchProductDetails(productId); 
          fetchCategories(); 
        } else {
          alert('No product ID provided.');
        }
  
        $('#image-upload').on('change', function (event) {
        const [file] = event.target.files;
        if (file) {
          const reader = new FileReader();
  
          reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result).show();
            $('#preview-icon').hide();
            $('#upload-text').hide();
          };
  
          reader.readAsDataURL(file);
        }
      });
  
  
        $('#editProductForm').on('submit', function (e) {
          e.preventDefault();
          const formData = new FormData(this);
          formData.append('id', productId); 
  
          $.ajax({
            url: '../../controllers/update_product.php', 
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
            let jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
  
            console.log(jsonResponse);
  
            if (jsonResponse.success) {
              alert('Product updated successfully.');
              window.location.href = 'dashboard.php'; 
            } else {
              alert('Failed to update product. Please try again.');
            }
          }
  
          });
        });