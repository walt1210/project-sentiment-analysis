window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });



  
  $(document).ready(function() {
    // Initialize DataTable
    $('#reviewsTable').DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: './../../controllers/get_prod_revs_user.php', // Adjust the path to your API
        type: 'GET',
        dataSrc: function(json) {
          if(json.success){
            return json.data; // Return the data array from the response
          } else {
            alert('No reviews found.');
            return []; // Return an empty array if no reviews found
          }
       }
      },
      columns: [
        { data: 'product_name', render: function(data) {
            return data.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letter of each word
          }
        },
        { data: 'category_name', render: function(data) {
            return data.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letter of each word
          }
        },
        { data: 'review_text' },
        { data: 'rating', render: function(data) {
            return '⭐'.repeat(data); // Render stars based on rating
          }
        },
        { data: 'type', render: function(data) {
            return data.charAt(0).toUpperCase() + data.slice(1); // Capitalize first letter of sentiment type
          }
        },
        { data: 'id', render: function(data) {
            return `<button class="btn btn-sm btn-warning edit-review" data-id="${data}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-review" data-id="${data}">Delete</button>`;
          }
        }
      ],
      paging: true,
      searching: true,
      ordering: true,
      lengthChange: true,
      pageLength: 5 // Display 5 reviews per page
    });



    $('#reviewsTable tbody').on('click', '.edit-review', function() {
      let dataId = $(this).attr('data-id');
      //alert("Button clicked for ID: " + dataId);
      // Fetch review details via AJAX
      $.ajax({
        url: './../../controllers/get_one_prod_rev.php', // Adjust the path to your API
        method: 'GET',
        data: { id: dataId },
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Populate the modal with review data
            $('#reviewId').val(response.review.id);
            $('#productName').val(response.review.product_name.replace(/\b\w/g, char => char.toUpperCase()));
            $(`input[name="rating"][value="${response.review.rating}"]`).prop('checked', true);
            $('#reviewText').val(response.review.review_text);

            // Show the modal
            $('#editReviewModal').modal('show');
          } else {
            alert('Failed to fetch review details.');
          }
        },
        error: function () {
          alert('An error occurred while fetching review details.');
        },
      });
    });






     // Handle Edit Review Form Submission
     $('#editReviewForm').on('submit', function (e) {
      e.preventDefault();

      const formData = $(this).serialize()  + "&action=" + encodeURIComponent("edit"); // Serialize the form data
      // Submit the edited review via AJAX
      $.ajax({
        url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
          if(response.success) {
            alert(response.msg);
            $('#editReviewModal').modal('hide');
            location.reload(); // Reload the page to reflect changes
          } else {
            alert('Failed to update review.');
          }
        },
        error: function () {
          alert('An error occurred while updating the review.');
        },
      });
    });



    //delete review
    $('#reviewsTable tbody').on('click', '.delete-review', function() {
      let dataId = $(this).attr('data-id');
      //alert("Button clicked for ID: " + dataId);


      if(confirm('Are you sure you want to delete?')){
        $.ajax({
        url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
        method: 'POST',
        data:   { action:"delete", review_id: dataId },
        dataType: 'json',
        success: function (response) {
          if(response.success) {
            alert(response.msg);
            $('#editReviewModal').modal('hide');
            location.reload(); // Reload the page to reflect changes
          } else {
            alert('Failed to delete review.');
          }
        },
        error: function () {
          alert('An error occurred while deleting the review.');
        },
      });
      }
      
    });

});