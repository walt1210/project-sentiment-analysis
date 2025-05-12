$(document).ready(function () {
    // Fetch categories from the backend
    function fetchCategories() {
      $.ajax({
        url: '/project-sentiment-analysis/api/get_categories.php', // Adjust the path to your API
        method: 'GET',
        success: function (response) {
          if (response.success) {
            const categoryDropdown = $('#categoryDropdown');
            categoryDropdown.empty();
            categoryDropdown.append('<option value="" disabled selected>Select Category</option>');
            response.categories.forEach(function (category) {
              categoryDropdown.append(`<option value="${category.id}">${category.name}</option>`);
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

    // Fetch products based on the selected category
    $('#categoryDropdown').on('change', function () {
      const categoryId = $(this).val();
      $.ajax({
        url: '/project-sentiment-analysis/api/get_products.php', // Adjust the path to your API
        method: 'GET',
        data: { category_id: categoryId },
        success: function (response) {
          if (response.success) {
            const productDropdown = $('#productDropdown');
            productDropdown.empty();
            productDropdown.append('<option value="" disabled selected>Select Product</option>');
            response.products.forEach(function (product) {
              productDropdown.append(`<option value="${product.id}">${product.name}</option>`);
            });
          } else {
            alert('Failed to fetch products.');
          }
        },
        error: function () {
          alert('An error occurred while fetching products.');
        },
      });
    });

    // Initialize categories on page load
    fetchCategories();
  });