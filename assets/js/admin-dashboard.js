window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); 
    }
  });
    $(document).ready(function () {
      // Initialize DataTables for Product List Table
      $('#productTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        autoWidth: false,
      });

  function fetchProducts() {
  $.ajax({
    url: './../../controllers/get_products.php',
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      console.log(response); // Log the response to check the structure
      if (response.success) {
        const productsTable = $('#productTable').DataTable();
        productsTable.clear();
        response.data.forEach(function (product) {
          const productName = product.name ? product.name.replace(/\b\w/g, char => char.toUpperCase()) : '';
          const categoryName = product.category_id ? product.category_id.replace(/\b\w/g, char => char.toUpperCase()) : '';
          const price = product.price ? `₱${parseFloat(product.price).toFixed(2)}` : '₱0.00';
          const image = product.image_url ? `<img src='../../${product.image_url}' width='60'>` : '';
            // const image = product.image ? `<img src='../../uploads/${product.image}' width='60'>` : '';
          const actions = `
            <a href='edit_product.php?id=${product.id}' class='btn btn-sm btn-primary'>Edit</a>
            <button class='btn btn-sm btn-danger delete-btn' data-id='${product.id}'>Delete</button>
          `;

          productsTable.row.add([ 
            product.id,
            productName,
            categoryName,
            price,
            image,
            actions
          ]);
        });
        productsTable.draw();
      } else {
        alert('Failed to fetch products.');
      }
    },
    error: function () {
      alert('An error occurred while fetching products.');
    },
  });
}

fetchProducts();

$(document).on('click', '.delete-btn', function () {
  const productId = $(this).data('id');
  console.log("Product ID to delete: ", productId);  // Log productId to check
  
  if (confirm('Are you sure you want to delete this product?')) {
    $.ajax({
      url: 'delete_product.php',
      method: 'GET',
      data: { id: productId },
      success: function(response) {
        console.log(response);  
        
        try {
          response = JSON.parse(response);  
        } catch (error) {
          console.error('Failed to parse JSON response:', error);
        }
        
        if (response.success) {
          alert('Product deleted successfully.');
          location.reload(true);  
        } else {
          alert('Failed to delete the product. ' + (response.message || ''));
        }
      },
      error: function() {
        alert('An error occurred while deleting the product.');
      },
    });
  }
});


function deleteProduct(productId) {
  $.ajax({
    url: '/project-sentiment-analysis/views/admin/delete_product.php',  // Ensure this is the correct URL
    method: 'GET',
    data: { id: productId },
    success: function (response) {
      if (response.success) {
        alert('Product deleted successfully.');
        location.reload();
      } else {
        alert('Failed to delete the product.');
      }
    },
    error: function () {
      alert('An error occurred while deleting the product.');
    },
  });
}

      // Initialize DataTables for Product Reviews Table
      $('#reviewsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        autoWidth: false,
      });

      function fetchReviews() {
        $.ajax({
          // url: '/project-sentiment-analysis/api/get_reviews.php',
          url: './../../controllers/get_all_reviews.php', 
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              const reviewsTable = $('#reviewsTable').DataTable();
              reviewsTable.clear(); 
              response.data.forEach(function (review) {
                reviewsTable.row.add([
                  review.product_name.replace(/\b\w/g, char => char.toUpperCase()),
                  review.category_name.replace(/\b\w/g, char => char.toUpperCase()),
                  review.email,
                  '★'.repeat(review.rating),
                  review.review_text,
                  review.type.replace(/\b\w/g, char => char.toUpperCase())
                ]);
              });
              reviewsTable.draw(); 
            } else {
              alert('Failed to fetch reviews.');
            }
          },
          error: function () {
            alert('An error occurred while fetching reviews.');
          },
        });
      }

      fetchReviews();

      $(document).on('click', '.discard-review', function () {
        const reviewId = $(this).data('id');
        if (confirm('Are you sure you want to discard this review?')) {
          $.ajax({
            url: '/project-sentiment-analysis/api/discard_review.php', 
            method: 'POST',
            data: { id: reviewId },
            success: function (response) {
              if (response.success) {
                alert('Review discarded successfully.');
                fetchReviews(); 
              } else {
                alert('Failed to discard review.');
              }
            },
            error: function () {
              alert('An error occurred while discarding the review.');
            },
          });
        }
      });

      $.ajax({
        url: './../../controllers/get_product_with_total_sentiment.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          let labels = [];
          let positive = [];
          let neutral = [];
          let negative = [];

          response.data.forEach(function (item) {
            labels.push(item.product);
            positive.push(parseInt(item.positive));
            neutral.push(parseInt(item.neutral));
            negative.push(parseInt(item.negative));
          });

          const ctx = document.getElementById('sentimentChart').getContext('2d');

          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [
                {
                  label: 'Positive',
                  data: positive,
                  backgroundColor: 'rgba(100, 181, 246, 0.7)'
                },
                {
                  label: 'Neutral',
                  data: neutral,
                  backgroundColor: 'rgba(92, 107, 192, 0.7)'
                },
                {
                  label: 'Negative',
                  data: negative,
                  backgroundColor: 'rgba(40, 53, 147, 0.7)'
                }
              ]
            },
            options: {
              responsive: true,
              plugins: {
                tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw}%`;
                                }
                            }
                        },
                title: {
                  display: true,
                  text: 'Sentiment Breakdown by Product'
                }
              },
              scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true,  max: 100,
                            title: {
                                display: true,
                                text: 'Percentage'
                            }
                }
              }
            }
          });
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + error);
        }
      });
    });