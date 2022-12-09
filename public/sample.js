$(document).ready(function () {
    $('#upload').on('click', function() {
        upload()
    })
})


const upload = () =>{
    var formdata = new FormData(document.getElementById('form_data'))
    // var image = document.getElementById('image').files[0]
    // formdata.append('file', image)

    $.ajax({
        url: 'route.php',
        type: 'POST',
        data: {choice: 'upload', image_file: formdata},
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data)
        }
    })
}