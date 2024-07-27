

document.getElementById('equipment_state').addEventListener('change', function(event){
    var destinationElement = document.getElementById('distination');

    destinationElement.innerHTML='';
    if(this.value=='utiliser'){
        var sourceElement = document.getElementById('employeesList');
        destinationElement.innerHTML=sourceElement.innerHTML;
    }else if(this.value=='mantonance'){
        var sourceElement = document.getElementById('mantonance_Desc');
        destinationElement.innerHTML=sourceElement.innerHTML;
    }
    else{
        destinationElement.innerHTML='';
    }   
});