var xid

$(document).ready(function() {// Ready ang html document
    displayFlight()//e display ang mga data sa database

    $(document).on('click', '#logout', function() {
        logout()//para sa logout ug e click
    })
    var count = 0// mao ni ang click count
    
    $(document).on('click', '#test', function() {//click count #1
        count += 1//inig click sa test mo increment ni
        if (count == 1) {//condition ni para e check ang value sa click count
            $('#table').addClass('d-none')
            $('#site-modal').removeClass('d-none');
        }
        if (count == 2) {//parihas rasa diri show and hide ni
            $('#table').removeClass('d-none')
            $('#site-modal').addClass('d-none');
            count = 0
        }
    })
    
    $(document).on('click', '#test-submit', function() {
        if (checkValid()) {//check ug ang mga inputs di blangko or empty if di blangko mo proceed siya sa ubos
            $('#flight_id').val('')
            addFlight()
        }else{
            alert("Please input missing fields")
        }
    })
    $(document).on('click', '.upgrade', function() {//click count #2 
        xid = $(this).attr('id')
        count += 1//same rani sila sa #1
        if (count == 1) {
            $('#table').addClass('d-none')//adding bootstrap class d-none
            $('#upgrade-modal').removeClass('d-none');//removing bootstrap class d-none
        }
        if (count == 2) {//same ra sa babaw
            $('#table').removeClass('d-none')
            $('#upgrade-modal').addClass('d-none');
            count = 0
        }
    })
    $(document).on('click', '#upgrade', function() {
        if (confirm("Will you upgrade this record??")) {//kani diri iconfirm sa usa mo proceed s update()
            update()
        }        
    })

    
    
    $(document).on('click', '#close', function () {//ug ma click ang close 
        $('#table').removeClass('d-none')//iremove ang d-none na class
        $('#upgrade-modal').addClass('d-none');//same ra sa babaw
        location.reload()//e reload ang page
    })


    $(document).on('click', '.delete', function () {
        xid = $(this).attr('id')//inig click sa delete na button kuhaon ang id value
        if (confirm("Are you sure you want to DELETE this record?")) {//confirm gihapon usa mo proceed sa ubos
            deleteFlight()
            location.reload()

        }
    })
})

const deleteFlight = () => {//mao ni ang function na tawagon sa kada click 
    $.ajax({
        type: 'POST',//method type
        url: 'src/router.php',//directory path sa router.php script
        data: {
            choice: 'delete', id:xid//mao ni ang ipasa sa router na naay choice na delete
        },
        success: function(params) {
            if (params == "200") {
                alert("Flight Record Deleted Successfully")
                location.reload()
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError)
        }
    })
}

const update = () => {
    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {
            choice: 'upgrade',
            id:xid,
            speed:$('#upgradeSpeed').val(),
            destination: $('#upgradeDes').val(),
            gas_tank:$('#upgradeGas').val()
        },
        success: function(data) {
            console.log(data)
            if (data =='200') {
                alert("Upgrade Successfuly")
                location.reload()

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError)
        }
    })
}

/**
 * ang tanang function same ra ug flow mag sigi rana silag pasa pasa sa mga gipang kuha sa html
 * gamit ang ajax na mo send sa mga values na gikuha sa html padung sa php file sa router
 * ang tanang location.reload na pangan sa html kung asa nimo e reload
 * 
 * 
 */

const displayFlight = () => {
    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {
            choice: 'display'
        },
        success: function(params) {
            var json = JSON.parse(params)
            var count = 1
            var output = "<table class='table table-responsive-xxl justify-content-center'>"+
            "<tr>"+
                "<th width='10%'>ID</th>" + 
                "<th width='30%'>Plane Type</th>" + 
                "<th width='15%'>Speed</th>" + 
                "<th width='15%'>Destination</th>" + 
                "<th width='15%'>Gas Tank</th>" + 
                "<th width='40%'>Date</th>" +
            "</tr>"

            json.forEach(element => {
                output += "<tr>"
                output += "<td>" + count + "</td>"
                output += "<td>" + element.plane_type + "</td>"
                output += "<td>" + element.speed + "</td>"
                output += "<td>" + element.destination + "</td>"
                output += "<td>" + element.gas_tank + "</td>"
                output += "<td>" + element.date + "</td>"
                output += "<td><input type='button' class='btn btn-info upgrade' id='"+ element.id +"' value='Upgrade'></td>"
                output += "<td><input type='button' class='btn btn-danger delete' id='"+ element.id +"' value='Delete'></td>"
                output += "</tr>"
                count += 1                
            });
            $('#table').append(output)
        }

    })
}

const addFlight = () => {
    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {
            choice:'addFlight', plane_type:$('#plane-type').val(), speed:$('#speed').val(), distanation:$('#distanation').val(), tank_size:$('#tank-size').val()
        },
        success: function(params) {
            if(params == "200"){
                alert('Add flight test successfully')
                $('#plane-type').val('')
                $('#speed').val('')
                $('#distanation').val('')
                $('#tank-size').val('')
                $('#site-modal').addClass('d-none');
                location.reload()
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError)
        }
    })
}

const checkValid = () => {
    var count = 2
    if ($('#plane-type').val() == '' && $('#distanation').val() == '') {
        count -= 1
    }
    if (parseInt($('#speed').val()) == NaN && $('#tank-size').val() == NaN) {
       count -= 1 
    }

    if (count == 2) {
        return true
    }
    else{
        return false
    }
}

const logout = () => {
    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {choice: 'logout'},
        success: function(params) {
            if (params == "200") {
                $(location).attr('href', './index.html')
            }
        }
    })
}