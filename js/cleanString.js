/* 
 Limpiar cadenas de caracteres
 */

function getInputs(){
    var inputs = document.querySelectorAll("input[type=text]");
    for (var i = 0; i < inputs.length; i++) {
   var e = inputs[i];
     //alert(e.name + e.type);
    
     e.addEventListener('blur',function (){
         clean(this);
     },false);
    }
    
}

function clean(ele){
   

   var string = ele.value;
   
   string = string.replace(/á/gi,"A");
   string = string.replace(/é/gi,"E");
   string = string.replace(/í/gi,"I");
   string = string.replace(/ó/gi,"O");
   string = string.replace(/ú/gi,"U"); 
   string = string.replace(/[^ña-zA-Z0-9\s,/\/\.]/g, "");
   string = string.toUpperCase();
   ele.value = string; 
    
}

 function agregarCero(val) {
    var string = '' + val;
    while (string.length < 5) {
    string = '0' + string;
    }
    return string;
}


