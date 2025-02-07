$(document).ready(function() {
    $('input[type="checkbox"]:not(#Allcat)').prop('checked', true);
    $('#Allcat').on('change', function() {
        if ($(this).is(':checked')) {
            $('input[type="checkbox"]:not(#Allcat)').prop('checked', true);
            $('.image-item').show();
        } else {
            $('input[type="checkbox"]:not(#Allcat)').prop('checked', false);
            $('.image-item').hide();
        }
    });

    $(document).on('change', 'input[type="checkbox"]:not(#Allcat)', function() {
        // If all individual checkboxes are checked, check "All Categories"
        const totalCheckboxes = $('input[type="checkbox"]:not(#Allcat)').length;
        const checkedCheckboxes = $('input[type="checkbox"]:not(#Allcat):checked').length;

        if (checkedCheckboxes === totalCheckboxes) {
            $('#Allcat').prop('checked', true);
        } else {
            $('#Allcat').prop('checked', false);
        }

        // Filter images based on checked categories
        if (checkedCheckboxes > 0) {
            $('.image-item').hide(); // Hide all images first
            $('input[type="checkbox"]:not(#Allcat):checked').each(function() {
                const categoryId = $(this).data('category-id');
                const subcategoryId = $(this).data('subcategory-id');

                // Show images matching the selected categories and subcategories
                $(`.image-item[data-category-id="${categoryId}"][data-subcategory-id="${subcategoryId}"]`)
                    .show();
            });
        } else {
            $('.image-item').hide(); // Hide all images if no checkboxes are checked
        }
    });
    $('#resetCategories').on('click', function(e) {
         e.preventDefault(); 
        $('#Allcat').prop('checked', false);
        $('input[type="checkbox"]:not(#Allcat)').prop('checked', false);
        $('.image-item').hide();
    });

    document.querySelectorAll('.collection-menu').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    });

    const $cookiesBox = $('.cookies-track');

    if (!localStorage.getItem('cookiesBoxDismissed')) {
        setTimeout(() => {
            $cookiesBox.addClass('active');
        }, 500);
    }

    $('.close-btn').on('click', function () {
        $cookiesBox.removeClass('active');
        localStorage.setItem('cookiesBoxDismissed', 'true');
    });

    $(document).on('input','#search_design_category',function(){

        var search_value=$(this).val();
        $('#home_loader').css('display','flex');
        $.ajax({
            url: base_url + "search_features", 
            method: 'GET',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            // },
            data: { search: search_value}, 
            success: function (response) {
                console.log("Remove successful: ", response);
    
                if (response.view) {
                 $('.list_all_design_catgeory').html('');
                 $('.list_all_design_catgeory').html(response.view);
                 $('#home_loader').css('display','none');
                    
                } else {
                }
            },
            error: function (error) {
            
            }
        });
    });
});