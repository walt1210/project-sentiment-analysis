window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });

  $(document).ready(function () {
    // Fetch categories from the backend
    function fetchCategories(selectedCategoryID = null) {
      $.ajax({
        url: './../../controllers/get_categories.php', // Adjust the path to your API
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.length > 0) {
            const categoryDropdown = $('#categoryDropdown');
            categoryDropdown.empty();
            categoryDropdown.append('<option value="" selected>All Category</option>');
            response.forEach(function (category) {
              var c_name = category.name.replace(/\b\w/g, char => char.toUpperCase())
              categoryDropdown.append(`<option value="${category.id}">${c_name}</option>`);
            
              if (selectedCategoryID) {
                categoryDropdown.val(selectedCategoryID);
              }
            
            });
          } else {
            alert('Failed to fetch categories.');
          }
        },
        error: function () {
          alert('An error occurred while fetching categories.');
        },
      });
    }


    function fetchProducts(categoryID = null, productID=null) {
      
      $.ajax({
        url: './../../controllers/get_products.php', // Adjust the path to your API
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            const productDropdown = $('#productDropdown');
            productDropdown.empty();
            productDropdown.append('<option value="" disabled selected>Select Product</option>');
            response.data.forEach(function (product) {
              console.log(product.category_id, categoryID) ;

              if(!categoryID || product.category_id == categoryID){
                var p_name = product.name.replace(/\b\w/g, char => char.toUpperCase())
                productDropdown.append(`<option value="${product.id}" data-category_id="${product.category_id}" >${p_name}</option>`);
             
              }
              
            });
            if (productID) {
              productDropdown.val(productID);
            }
          } else {
            alert('Failed to fetch products.');
          }
        },
        error: function () {
          alert('An error occurred while fetching products.');
        },
      });
    }


    //Store data to database
    $('#submit-review_form').on('submit', function (e) {
      e.preventDefault(); // Prevent the default form submission
      const form = $(this);
      const formData = form.serialize()  + "&action=" + encodeURIComponent("add"); // Serialize the form data

      $.ajax({
        url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            //form[0].reset();
            // fetchCategories();
            // fetchProducts();
            alert('Review submitted successfully!');
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState(null, null, cleanUrl);
            location.reload();
            //window.location.href = 'submit_review.php'; // Redirect to view reviews page
          } else {
            alert('Failed to submit review.');
          }
        },
        error: function () {
          alert('An error occurred while submitting the review.');
        },
      });
    });





    // Fetch products based on the selected category
    $('#categoryDropdown').on('change', function () {
      const categoryID = $(this).val() ? $(this).val() : null;
      fetchProducts(categoryID);
    });
    
    //select category from product automatically
    $('#productDropdown').on('change', function () {
      $('#categoryDropdown').val($(this).find(':selected').data('category_id'));
    });
  
    
  }); 