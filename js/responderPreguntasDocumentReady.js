$(function(){
    
    function validate(formData, jqForm, options) { 
        for (var i=0; i < formData.length; i++) { 
            if (!formData[i].value) { 
                return false; 
            } 
        } 
        jqForm.hide();
        return true;
    }
    function showResponse(responseText, statusText, xhr, $form)  {  
        $res = $form.parent(".respuesta");
        $res.html(responseText);
        $form.remove();
    }
            
    var preguntaOptions = { 
        beforeSubmit: validate,        
        success: showResponse
    }; 
    $('.preguntarForm').ajaxForm(preguntaOptions);
});