window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });

    $(document).ready(function () {
        var ctgry = {};

        loadCategories(function() {
            loadProducts(); // Will now run *after* categories are fully loaded
        });


        //load Categories
        function loadCategories(callback) {
            $("#categoryDropdown").empty();
            $("#categoryDropdown").append($('<option>', {
                value: "all",
                text: "All Categories"
            }));

            $.getJSON("../../controllers/get_categories.php", function(result){
                $.each(result, function(index, categories) {
                    ctgry[categories.id] = categories.name;

                    $("#categoryDropdown").append($('<option>', {
                        value: categories.name,
                        text: categories.name.split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" "),
                        id: categories.id
                    }));

                    console.log(categories.id + ": " + categories.name);
                });

                //Categories are loaded, now call the callback
                if (typeof callback === "function") {
                    callback();
                }
            });
        }


        function loadProducts(){
            $("#productRecommendations").empty();
            var append = "";
            $.getJSON("../../controllers/get_products.php", function(result){
                $.each(result.data, function(index, products) {
                    let cat_name = ctgry[products.category_id];
                    if (typeof cat_name === "string" && cat_name.trim() !== "") {
                        cat_name = cat_name.replace(/\b\w/g, char => char.toUpperCase());
                    } else {
                        cat_name = "Unknown";
                    }
                    let prod_name = products.name.replace(/\b\w/g, char => char.toUpperCase());
                    append = `
                                 <div class="col-md-4">
                                    <div class="card">
                                    <img src="../../${products.image_url}" class="card-img-top" alt="${products.name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${prod_name}</h5>
                                            <p class="card-text">Category: ${cat_name}</p>
                                            <button class="btn btn-primary view-product" data-id="${products.id}" data-name="${products.name}">View Product Reviews</button>
                                        </div>
                                    </div>
                                </div>
                    `;
                    $("#productRecommendations").append(append);
                    //console.log(products.id + ": " + products.name);
                });

            });
        }
      
        function loadProductDetails(product_id) {
            $('#modalProductImage').attr('src', '');
            $('#modalProductName').text('');
            $('#modalProductCategory').text('');
            $('#likeCount').text('');
            $('#unlikeCount').text('');

            $('#likeButton').removeData('product-id'); 
            $('#unlikeButton').removeData('product-id'); 
            $('#btnComment').removeData('href');

            return $.ajax({
                url: '../../controllers/get_one_product.php',
                method: 'GET',
                data: { "product_id": product_id },
                dataType: 'json'
            }).then(function(response) {
                if (response.success) {
                    const category = ctgry[response.data.category_id]
                        .split(" ")
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(" ");

                    $('#modalProductImage').attr('src', `../../${response.data.image_url}`);
                    var prod_name = response.data.name.replace(/\b\w/g, char => char.toUpperCase());
                    $('#modalProductName').text(prod_name);
                    $('#modalProductCategory').text(`Category: ${category}`);
                    $('#likeCount').text(response.data.like_count);
                    $('#unlikeCount').text(response.data.dislike_count);

                    $('#likeButton').data('product-id', product_id); 
                    $('#unlikeButton').data('product-id', product_id);
                    $('#btnComment').data('href', `submit_review.php?product_id=${product_id}&category=${response.data.category_id}`); // Set the data attribute for the button

                    //console.log($('#likeButton').data('product-id'));

                    const lk = ['like', 'dislike'];

                    // if (lk.includes(response.data.user_vote)) {
                      //console.log('Yes, banana is in the list!');
                      updateUI(response.data.user_vote);
                      console.log("vote" + response.data.user_vote);
                    // }


                    return true;
                } else {
                    alert("Product failed to load. Please try again later.");
                    return false;
                }
            }).catch(function() {
                alert("Error occurred while loading product details.");
                return false;
            });
        }

        function loadReviews(product_id) {
            $('#productComments').empty();

            return $.ajax({
                url: '../../controllers/get_reviews_of_product.php',
                method: 'GET',
                data: { "product_id": product_id },
                dataType: 'json'
            }).then(function(response) {
                if (response.success) {
                    const data = response.data;
                    let commentsHtml = '';

                    data.forEach(review => {
                        commentsHtml += `
                            <div class="mb-4">
                                <strong>${review.user_name}</strong>
                                <small class="text-muted">(${review.name})</small>
                                <p>${'⭐'.repeat(review.rating)} (${review.rating}/5)</p>
                                <p>${review.review_text}</p>
                                <hr>
                            </div>`;
                    });

                    $('#productComments').html(commentsHtml);
                    return true;
                } else {
                    alert("Product reviews failed to load. Please try again later.");
                    return false;
                }
            }).catch(function() {
                alert("Error occurred while loading reviews.");
                return false;
            });
        }

        $(document).on("click", ".view-product", function() {
            const productId = $(this).data('id');
            const productName = $(this).data('name');

            $.when(loadProductDetails(productId), loadReviews(productId)).done(function(resultA, resultB) {
                if (resultA && resultB) {
                    console.log('Both product and reviews loaded successfully');
                    $('#productReviewModal').modal('show');
                } else {
                    console.log('One or both failed to load');
                }
            });
        });

        let currentStatus = null; // 'like' or 'unlike'

        function updateUI(status) {
            currentStatus = status;
            if (status === 'like') {
              $('#likeButton').css('background-color', '#388E3C');
                $('#unlikeButton').css('background-color', '#FFAB91');
            } else if(status =="dislike") {
              $('#unlikeButton').css('background-color', '#F44336');
                $('#likeButton').css('background-color', '#81C784');
            }
            else {
                $('#likeButton').css('background-color', '#81C784');
                $('#unlikeButton').css('background-color', '#FFAB91');
            }
        }

        //function for if the user has liked or disliked the product, show on load of modal tapos na
        function updateProductVote(vote, product_ID){
          $.ajax({
            url: '../../controllers/product_vote_controller.php',  // your backend URL
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                product_id: product_ID,      // Example data
                user_vote: vote
            }),
            success: function(response) {
                console.log('Server response:', response.msg);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
        }

        //function for every click of like or dislike button 

          $('.reaction-btn').on('click', function() {
            //if like button is clicked, update the product vote to like
            // and update the UI accordingly
            if ($(this).attr('id') == 'likeButton') {
              $(this).data('product-id');
              updateProductVote('like', $(this).data('product-id'));
              updateUI('like');
            } 
            //If unlike button is clicked, update the product vote to dislike
            // and update the UI accordingly
            else if ($(this).attr('id') == 'unlikeButton') {
              updateProductVote('dislike', $(this).data('product-id'));
              updateUI('dislike');
            }
          });



          $('#btnComment').on('click', function() {
            let url = $(this).data('href');
            window.location.href = url;
          });

      // Filter products based on search input
      $('#searchInput').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        $('#productRecommendations .card').filter(function() {
          $(this).parent().toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
      });

      // Filter products based on category dropdown
      $('#categoryDropdown').on('change', function() {
        const selectedCategory = $(this).val().toLowerCase();
        $('#productRecommendations .card').filter(function() {
          if (selectedCategory === 'all') {
            $(this).parent().show();
          } else {
            $(this).parent().toggle($(this).find('.card-text:contains("Category:")').text().toLowerCase().includes(selectedCategory));
          }
        });
      });
    });