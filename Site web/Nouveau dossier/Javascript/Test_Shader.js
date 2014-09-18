//Test_Shader.js
// Fait par : Simon Bouchard
// Créer le : 2014-09-17
// Fichier contenant les fonctions de gogossage de l'option Shaders.





Dialog.confirm($('login').innerHTML, {className:"alphacube", width:400, 
                                      okLabel: "login", cancelLabel: "cancel",
                                      onOk:function(win){
                                        $('login_error_msg').innerHTML='Login or password inccorect';
                                        $('login_error_msg').show(); 
                                        Windows.focusedWindow.updateHeight();
                                        new Effect.Shake(Windows.focusedWindow.getId()); return false;}});