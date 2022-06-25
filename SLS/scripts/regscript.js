function validate(){
    var adm= document.forms['myForm']['admission'];
    var fn= document.forms['myForm']['fullname'];
    var em= document.forms['myForm']['email'];
    var pass= document.forms['myForm']['password'];
    var cpass= document.forms['myForm']['cpassword'];


    if(adm.value==""){
        document.getElementById("ade").innerHTML="Admission Number Required";
        adm.focus();
        return false;
        }
        else{
            document.getElementById("ade").innerHTML="";
        }

        if(fn.value==""){
            document.getElementById("fne").innerHTML="Full Name Required";
            fn.focus();
            return false;
            }
            else{
                document.getElementById("fne").innerHTML="";
            }
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
        if(pass.value!=cpass.value){
                        document.getElementById("cpasse").innerHTML="PAsswords dont Match";
                        cpass.focus();
                        return false;
                        }
                        else{
                            document.getElementById("cpasse").innerHTML="";
                        }



                     
        }

