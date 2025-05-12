window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); 
    }
  });
    $(document).ready(function () {
      function fetchCategories() {
        $.ajax({
          url: './../../controllers/get_categories.php',
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response.length > 0) {
              const categoryDropdown = $('#category');
              categoryDropdown.empty();
              // categoryDropdown.append('<option value="" selected>All Category</option>');
              response.forEach(function (category) {
                var c_name = category.name.replace(/\b\w/g, char => char.toUpperCase())
                categoryDropdown.append(`<option value="${category.id}">${c_name}</option>`);
              
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

      fetchCategories();

      $('#image-upload').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#image-preview').attr('src', e.target.result).show(); 
            $('#preview-icon').hide(); 
            $('#upload-text').show();
          };
          reader.readAsDataURL(file); 
        } else {
          $('#image-preview').hide(); 
          $('#preview-icon').show(); 
          $('#upload-text').show(); 
        }
      });

      $('#addProductForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
          url: 'add_products.php', 
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
          console.log("Response from server:", response);
            if (response.success) {
              alert('Product added successfully.');
              $('#addProductForm')[0].reset();
              $('#image-preview').hide();
              $('#preview-icon').show();
              $('#upload-text').show();
            } else {
              alert('Failed to add product. Please try again.');
            }
          },
          error: function () {
            alert('An error occurred. Please try again.');
          },
        });
      });
    });