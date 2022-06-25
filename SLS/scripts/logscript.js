function validate(){
    
    var em= document.forms['myForm']['email'];
    var pass= document.forms['myForm']['password'];
    
        if(em.value==""){
                document.getElementById("eme").innerHTML="Email Required";
                em.focus();
                return false;
                }
                else{
                    document.getElementById("eme").innerHTML="";
                }
        if(pass.value==""){
                    document.getElementById("passe").innerHTML="Password Required";
                    pass.focus();
                    return false;
                    }
                    else{
                        document.getElementById("passe").innerHTML="";
                    }
            //  return false;   
        }

