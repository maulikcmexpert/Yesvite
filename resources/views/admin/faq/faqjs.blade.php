<script type="text/javascript">
    var base_url = "{{ url('/') }}/";
    $(function() {


            $('#faq_add_form').validate({
                    rules: {
                        question: {
                            required: true
                        },
                        answer: {
                            required: true
                        }
                    },
                    messages: { 
                        question: {
                            required: "Please enter the question"
                        },
                        answer: {
                            required: "Please enter the answer"
                        }
                    },
        });





        var table = $("#template_table").DataTable({
            processing: true,
            serverSide: true,


            ajax: '{{ URL::to('/admin/faq') }}',
            columns: [{

                    data: "number",

                    name: "number"

                },

                {

                    data: "question",

                    name: "question"

                },

                {

                    data: "answer",

                    name: "answer"

                },



                {

                    data: "action",

                    name: "action",

                    orderable: false,

                    searchable: true,

                },

            ],
        });

        $("#addMoreTemplate").click(function() {
            var html = $("#AddHtml").html(); // Get the hidden HTML
            $("#appendHtml").append(html); // Append the HTML to the form
        });

        $(document).on("click", ".remove", function() {
            $(this).closest('.col-lg-3')
                .remove(); // Remove the entire col-lg-3 div containing the input
        });

        $(document).on('click', '.delete_faq', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete_faq_from').submit();

            }
        });
    })

        document.querySelectorAll('.question').forEach(function(textarea) {
            ClassicEditor
                .create(textarea)
                .then(editor => {
                    // Access the editor's editing view container
                    editor.ui.view.editable.element.style.height =
                    '100px'; // Set the desired height here
                })
                .catch(error => {
                    console.error(error);
                });
        });
        document.querySelectorAll('.answer').forEach(function(textarea) {
            ClassicEditor
                .create(textarea)
                .then(editor => {
                    // Access the editor's editing view container
                    editor.ui.view.editable.element.style.height = '100px';

                })
                .catch(error => {
                    console.error(error);
                });
        });

    });
</script>
