$("a.delete").on("click", function(e){
    e.preventDefault();

    if (confirm("are you sure?")){
        var frm = $("<form>");
        
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");

        frm.submit();
    }

});

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
})
