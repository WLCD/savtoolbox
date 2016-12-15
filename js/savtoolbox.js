//parse employees from customer id
$(document).ready(function(){
  
  $("#recipient").hide();
  $("#customer").change( function() {
        $("#recipient").hide();
        $("#result").html('Retrieving ...');
        $.ajax({
            type: "POST",
            data: "id=" + $("#customer :selected").val(),
            url: "bin/employees.php",
            success: function(msg){
                if (msg != ''){
                    $("#recipient").html(msg).show();
                    $("#result").html('');
                }
                else{
                    $("#result").html('<em>No item result</em>');
                }
            }
        });
    });
});

//reload page with form
//$(document).ready(function(){
//    $("#items_nb").change( function(){
//        //alert("cul");
//        $("div#news").load('bin/displaynews.php?page='+ $(document).getUrlParam("page") + '&items_nb=' + $("#items_nb :selected").val(), {value: $(this).val()});
//    });
//});

//checked collection status

$("#collect").change(function(){
    if (this.checked)
    {
        alert('Collection is checked !');
    }
});