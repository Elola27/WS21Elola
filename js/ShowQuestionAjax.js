/*function erakutsiJSONGalderak(){
    /*$.getJSON("../json/Questions.json").then(
    function(emaitza){
        /*var content="<table>"
        content+='<tr><th> Egilea </th><th> Galdera </th><th> Erantzun Zuzena </th></tr>';
        for (var i=0; i<emaitza.length; i++){
            content+='<tr><td>'+ emaitza[i].author +'</td><td>'+ emaitza[i].itembody.p +'</td><td>'+ emaitza[i].correctResponse.response+'</td></tr>';
            //$(tr).append("<td>"+emaitza[i].author+"</td>");
            //$(tr).append("<td>"+emaitza[i].itembody.p+"</td>");
            //$(tr).append("<td>"+emaitza[i].correctResponse.response+"</td>");
            //$('.table1').append(tr);
        }
        content+="</table>";
        $('#show').append(content);
        text="ONGI EGINA";
        $('#show').append(text);
    }).fail(function(){
        text="GAIZKI EGINA";
        $('#show').append(text);
    });
    $.ajax({
        url: '../json/Questions.json',
        dataType: 'json',
        cache:false,
        success: function(data){
            row=$('<table><tr><th> Galdera </th><th> Egilea </th><th> Erantzun Zuzena </th></tr>');
            //$('.show').append(row);
            for (var i=0; i<data.length; i++){
                row+=$('<tr><td>' + data[i].itembody.p + '</td><td>' + data[i].author + '</td><td>' + data[i].correctResponse.response + '</td></tr>');
                //$('#show').append("<p>Tonto</p>");    
            }
            row+=$('</table>');
            $('.show').html(row);
        },
        error: function(){
            alert('Errorea sortzearakoan');
        }
    });
}*/
$(function() {  
    $('#show').click(function() {
         $.ajax({
         url: '../json/Questions.json',
         dataType: 'json',
         cache:false,
         success: function(data) {
            $('#erakutsi').empty();
            row=('<p align="center">Hemen agertuko dira sortuta dauden galderak </p>');
            row+=('<table border=1id=taula style="margin-left:auto; margin-right:auto;">');
            row+=('<tr><th> Galdera </th><th> Egilea </th><th> Erantzun Zuzena </th></tr>');   
            $.each(data.assessmentItems,function(key,value){
                /*$.each(data.assessmentItems[key].itemBody,function(a,b){
                    balioa1=data.assessmentItems[key].itemBody[a].p;
                });
                $.each(data.assessmentItems[key].correctResponse,function(c,d){
                    balioa2=data.assessmentItems[key].correctResponse[c].response;
                });*/
                row+=('<tr><td>'+ value.itemBody.p+'</td><td> ' +value.author +'</td><td>'+/*$.each(data.assessmentItems[key].correctResponse,function(c,d){
                     return data.assessmentItems[key].correctResponse[c].value;
                })*/value.correctResponse.response+'</td></tr>');
            });
              //items.push('<li id="' + key + '">' + val + '</li>');    
              //row+=$('<table><tr><td>'+ data.itemBody.p+'</td><td>'+data.author +  '</td><td>' +data.correctResponse.response +  '</td></tr>');
            row+=('</table>');
            $('#erakutsi').append(row);
        },
        statusCode: {
           404: function() {
             alert('There was a problem with the server.  Try again soon!');
           }
        }
    });
  });
});


//setinterval(funtzioa,denbora)
//php
// zenbat galdera nireak
//zenbat galdera guztiak