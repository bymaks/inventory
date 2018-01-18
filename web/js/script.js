
function sendTool() {
    $.ajax({
        url: '/tools/inventory',
        type: "post",
        data: {
            'store_id':$('#ToolId').attr('store'),
            'code':$('#ToolId').val(),
        },
        success: function (data) {
            //console.log(data);

            var resp = JSON.parse(data);
            var classForEl = 'text-danger small';



            if(resp.status==1){
                classForEl = 'text-success small';
                $('#resultScan').addClass(classForEl);
                $('#resultScan').prepend('<span id="messages" timestmp="'+Date.now()+'" class="respMess">'+resp.message+' <a href="/tools/view?id='+resp.toolId+'" target="_blank">'+resp.toolCode+' '+resp.toolName+'</a> </span><br>');
            }
            else if(resp.status==2){
                $('#resultScan').addClass(classForEl);
                $('#resultScan').prepend('<span id="messages" timestmp="'+Date.now()+'" class="respMess">'+resp.message+' <a href="/tools/view?id='+resp.toolId+'" target="_blank">'+resp.toolCode+' '+resp.toolName+'</a> </span><br>');
            }
            else if(resp.status==3){
                $('#resultScan').addClass(classForEl);
                $('#resultScan').prepend('<span id="messages" timestmp="'+Date.now()+'" class="respMess">'+resp.message+' <a href="/tools/view?id='+resp.toolId+'" target="_blank">'+resp.toolCode+' '+resp.toolName+'</a> </span><br>');
            }
            else if(resp.status==4){
                $('#resultScan').addClass(classForEl);
                $('#resultScan').prepend('<span id="messages" timestmp="'+Date.now()+'" class="respMess">'+resp.message+'</span><br>');

            }
            $('#ToolId').removeAttr('disabled');
            $('#ToolId').val('');
            //console.log('empty');
            //console.log($('#resultScan').children('span').length);
        }
    });
    return false;
}
$(document).ready(function(){
    $('body').click(function(){
        $('#ToolId').focus();
        console.log('setFocus');
    });

    $(document).on('click','#sendBtn',function () {
        $('#ToolId').attr('disabled','disabled');
        $('#ToolId').attr('count',(parseInt($('#ToolId').attr('count'))+1));
        console.log('Disabled');
        if($('#ToolId').val().length>0){
            sendTool();
        }
        return false;
    });

    var enter=false;
    $('#ToolId').on('keypress', function(e){
        if(e.keyCode==13){
            enter = true;
        }
        else{
            enter = false;
        }
        //console.log('keyCode'+e.keyCode);

        if(enter==true) {
            $(this).attr('disabled','disabled');
            $(this).attr('count',(parseInt($(this).attr('count'))+1));
            console.log('Disabled');
            if($(this).val().length>0){
                sendTool();
            }
            return false;
        }
    });

    setInterval(function() {
        var element = $('.respMess').last();
        if(Date.now()-parseInt(element.attr('timestmp'))>5000){
            $('.respMess').last().remove();
        }
        console.log('rm');
    },1000);

});