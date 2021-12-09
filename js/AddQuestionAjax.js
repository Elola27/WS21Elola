function datuakegokiak(){
    eposta=document.getElementById("eposta").value;
    galdera=document.getElementById("galdera").value;
    erzuzen=document.getElementById("zuzen").value;
    eroker1=document.getElementById("oker1").value;
    eroker2=document.getElementById("oker2").value;
    eroker3=document.getElementById("oker3").value;
    zail=document.querySelector('input[name="zailtasun"]').value
    //zail=document.getElementById("zailtasun").value;
    arlo=document.getElementById("arlo").value;
    /*errez = document.getElementById("frmrdbtxikia").checked
    ertain = document.getElementById("frmrdbertaina").checked
    zaila = document.getElementById("frmrdbhandia").checked
    if (!(errez || ertain || zaila)) {valErrors += "Zailtasuna erabaki.\n"}*/
   

    var valErrors = ""

    if (!emailVal(eposta)) {valErrors += "Emaila ez da egokia.\n"}

    
    if (!ezHutsaVal(galdera) || !luzeraVal(galdera)) valErrors += "Galdera ez da egokia.\n"
    if (!ezHutsaVal(erzuzen)) valErrors += "Erantzun zuzena ez da egokia.\n"
    if (!ezHutsaVal(eroker1)) valErrors += "Erantzun okerra (1) ez da egokia.\n"
    if (!ezHutsaVal(eroker2)) valErrors += "Erantzun okerra (2) ez da egokia.\n"
    if (!ezHutsaVal(eroker3)) valErrors += "Erantzun okerra (3) ez da egokia.\n"
    if (zail===null) {valErrors += "Zailtasuna erabaki.\n"}
    if (!ezHutsaVal(arlo)) valErrors += "Gai arloa ez da egokia.\n"
    if(valErrors!=="") alert(valErrors)
    return valErrors===""

}

function emailVal(email) {
    var ikaslePattern = new RegExp(/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(eus|es)$/i)
    var irakasPattern = new RegExp(/^([a-zA-Z]+\.[a-zA-Z]+@ehu\.(eus|es)|[a-zA-Z]+@ehu\.(eus|es))$/i) //TODO sinplifikatu
    return ikaslePattern.test(email) || irakasPattern.test(email)
}

function luzeraVal(text){
    return text.length>=10
}
function ezHutsaVal(text){
    pattern = new RegExp(/\S+/i)
    return text.length>0 && pattern.test(text).valueOf()
}



function bidaliDatuak(){    
    //Datuak lortu 
    /*form=document.forms.galderenF;
    eposta=form.elements.eposta;
    galdera=form.elements.galdera;
    erzuzen=form.elements.erzuzen;
    eroker1=form.elements.eroker1;
    eroker2=form.elements.eroker2;
    eroker3=form.elements.eroker3;
    zail=form.elements.zail;
    arlo=form.elements.arlo;
    */
    eposta=document.getElementById("eposta").value;
    galdera=document.getElementById("galdera").value;
    erzuzen=document.getElementById("zuzen").value;
    eroker1=document.getElementById("oker1").value;
    eroker2=document.getElementById("oker2").value;
    eroker3=document.getElementById("oker3").value;
    zail=document.querySelector('input[name="zailtasun"]').value;
    //zail=document.getElementById("zailtasun").value;
    arlo=document.getElementById("arlo").value;

    formatua=datuakegokiak();
    balioa="eposta="+eposta+"&galdera="+galdera+"&erzuzen="+erzuzen+"&eroker1="+eroker1+"&eroker2="+eroker2+"&eroker3="+eroker3+"&zail="+zail+"&arlo="+arlo;
    xhro = new XMLHttpRequest();
    xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
        if (xhro.status==200){
            //document.getElementById("emaitza").append("Ondo joan da");
            document.getElementById("emaitza").innerHTML=xhro.responseText;
            //alert("Galdera ongi gorde da");
        } /*else{
            document.getElementById("emaitza").innerHTML="Gaizki";
        }*/
    }
    //Datuak bidali
    if (formatua==false){
        //alert("Datuak ez dira egokiak");
        return;
    }
    xhro.open("POST","../php/datuakGorde.php",true);
    xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xhro.send(balioa);
    xhro.send("eposta="+eposta+"&galdera="+galdera+"&erzuzen="+erzuzen+"&eroker1="+eroker1+"&eroker2="+eroker2+"&eroker3="+eroker3+"&zail="+zail+"&arlo="+arlo);
    //console.log("Heldu da");
}
