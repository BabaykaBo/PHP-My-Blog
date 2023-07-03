/**
 * Delete post
 */
$("a.delete").on("click", function(e){
    e.preventDefault();

    if (confirm("are you sure?")){
        var frm = $("<form>");
        
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");

        frm.submit();
    }});

/**
 * Validate post-form
 */
$.validator.addMethod("dateTime", function(value){
    return (value == "") || ! isNaN(Date.parse(value));
}, "Must be a valid date and time!");

$("#post-form").validate({
    rules: {
        title: {
            required: true
        },
        content: {
            required: true
        },
        published_at: {
            dateTime: true
        },
    }
});

/**
 * Publish post
 */
$("button.publish").on("click", function(e) {
    var id = $(this).data('id');
    var button = $(this);
    
    $.ajax({

        url: "/admin/publish.php",
        type: "POST",
        data: {id: id},

    }).done(function(data) {

        button.parent().html(data);

    }).fail(function(data) {

        alert("An error occurred!");

    });
});


$("#published_at").datetimepicker({
    format: 'Y-m-d H:i:s'
});