$(document).ready(function()
                {
                    $.betetadagoen = function()
                    {   
                        if (($("#eposta").val().length>0) &&($("#galdera").val().length>0 )&&($("#zuzen").val().length>0 )&&($("#oker1").val().length>0 )
                            &&($("#oker2").val().length>0 )&($("#oker3").val().length>0 )&&($("#arlo").val().length>0)&& $('input[name=zailtasun]').is(":checked"))
                        {
                            return true;
                        } 
                        else 
                        {
                            return false;
                        }
                    }

                    $.epostakonprobatu = function()
                    {
                        var balioa= $("#eposta").val();
                        if (balioa.match((/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(eus|es)$/)) || balioa.match((/^[a-zA-Z]\.[a-zA-Z]+@ehu\.(eus|es)$/)))
                        {
                            return true;
                        } 
                        else 
                        {
                            return false;
                        }
                    }
                    

                    $('#galderenF').submit(function() 
                     {
                        if ($.betetadagoen()) 
                        {
                            return true;
                            if ($.epostakonprobatu()) 
                            {
                                if ($("#galdera").val().length>=10)
                                {
                                    alert("Formularioa ondo bete da");
                                    return true;
                                } 
                                else 
                                {
                                    alert("Galderak gutxienez 10 karakterekoa izan behar dira");
                                    return false;
                                }         
                            } 
                            else
                            {
                                alert("Erabilitako e-posta elektronikoa okerra da");
                                return false;
                            }
                        } else 
                        {
                            alert("Hutsuneak daude, bete itzazu!");
                            return false;
                        }
                    })
                })