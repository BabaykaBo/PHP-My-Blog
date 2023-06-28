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
