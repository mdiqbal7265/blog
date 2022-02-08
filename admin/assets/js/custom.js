$(document).ready(function () {
  //Logout Ajax Request
  $("#logout").click(function () {
    $.ajax({
      type: "POST",
      url: "../lib/admin.php",
      data: { action: "logout" },
      success: function (response) {
        if (response == "logout") {
          window.location = "index.php";
        } else {
          iziToast.error({
            title: "Something Want Wrong!",
            message: "Please Try again Latter",
            position: "topRight"
          });
        }
      }
    });
  });

  // Fetch All Category

  fetchCategory();
  function fetchCategory() {
    $.ajax({
      type: "POST",
      url: "../lib/admin.php",
      data: { fetchCategory: "fetchCategory" },
      success: function (response) {
        $("#category_body").html(response);
      }
    });
  }

  // Add Category
  $("#add_category_btn").click(function (e) {
    e.preventDefault();
    $("#add_category_btn").val("Please wait...");

    $.ajax({
      type: "POST",
      url: "../lib/admin.php",
      data: $("#add_category_form").serialize() + "&action=add_category",
      success: function (response) {
        $("#add_category_btn").val("Add Category");
        $("#add_category_form")[0].reset();
        iziToast.success({
          title: "Added!",
          message: "Category Added Successfully!",
          position: "topRight"
        });
        fetchCategory();
        // console.log(response);
      }
    });
  });

  // Delete Category
  $("body").on("click", ".category_delete", function (e) {
    e.preventDefault();
    id = $(this).attr("id");
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this imaginary file!",
      icon: "warning",
      buttons: true,
      dangerMode: true
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",
          url: "../lib/admin.php",
          data: { action: "delete_category", id: id },
          success: function (response) {
            swal("Poof! Your Category has been deleted!", {
              icon: "success"
            });
            fetchCategory();
          }
        });
      } else {
        swal("Your Category is safe!");
      }
    });
  });

  //Edit Category
  $("body").on("click", ".category_edit", function (e) {
    e.preventDefault();
    id = $(this).attr("id");
    $("#add_card").hide();
    $("#edit_card").show();
    $.ajax({
      type: "POST",
      url: "../lib/admin.php",
      data: { action: "edit_category", id: id },
      success: function (response) {
        data = JSON.parse(response);
        $("#edit_id").val(data.id);
        $("#edit_category_name").val(data.category_name);
        if (data.status == $("#status").val()) {
          $("#status").attr("checked", "checked");
        }
      }
    });
  });

  // Update Category
  $("#edit_category_btn").click(function (e) {
    e.preventDefault();
    $("#edit_category_btn").val("Please wait...");

    $.ajax({
      type: "POST",
      url: "../lib/admin.php",
      data: $("#edit_category_form").serialize() + "&action=update_category",
      success: function (response) {
        $("#edit_category_btn").val("Update Category");
        $("#edit_category_form")[0].reset();
        $("#add_card").show();
        $("#edit_card").hide();
        iziToast.success({
          title: "Updated!",
          message: "Category Updated Successfully!",
          position: "topRight"
        });
        fetchCategory();
        // console.log(response);
      }
    });
  });

  // Ctegory Update Cancle
  $("#update_cancle").click(function(e){
    e.preventDefault();
    $("#add_card").show();
    $("#edit_card").hide();
  });

  // Refresh Category Content
  $("#refresh").click(function(){
    location.reload();
  });



  /*****End */
});
