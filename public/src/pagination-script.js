document.getElementById('recordsPerPage').addEventListener('change', function () {
    document.getElementById('recordsForm').submit();
    $.ajax({
        url: '/update-limit',
        type: 'POST',
        data: {
            limit: $(this).val()
        },
        success: function (result) {
            // Handle successful response if needed
        },
        error: function (xhr, status, error) {
            // Handle error if needed
        }
    });
});