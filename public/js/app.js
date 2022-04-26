// varriable

      var form = document.getElementById('login-form');
      var username = document.getElementById('username');
      var password = document.getElementById('password');
      var submitBtn = document.getElementById('submitBtn');
      

    
addAllEvents();

function addAllEvents(){

    document.addEventListener('DOMContentLoaded', appint);
    username.addEventListener('blur', validateField);
    password.addEventListener('blur', validateField);
    form.addEventListener('submit', submitForm);
}


function appint(){

    submitBtn.disabled = true;
    submitBtn.style.cursor = 'auto';

}


function validateField(){

    validateInput(this);
    validateEmail(this);

    let errors = document.querySelectorAll('.error');
    
    if(username.value !='' && password.value !=''){

        if(errors.length ==0){

            submitBtn.disabled = false;
            submitBtn.style.background = '#6ab04c';
            submitBtn.style.cursor = 'pointer';
        }

    }

    
}

function validateInput(field){

    if(field.value.length > 6){

        field.style.borderBottom = '1px solid green';
        field.classList.remove('error');
       
    }else{
        field.style.borderBottom = '1px solid red';
        field.classList.add('error');
        
    }
}

function validateEmail(field){

    if(field.type === 'email'){

        if(field.value.indexOf('@')!==-1){
            field.style.borderBottom = '1px solid green';
            field.classList.remove('error');
            
            
        }else{

            field.style.borderBottom = '1px solid red';
            field.classList.add('error');
            
        }
    }else{

        
    }
}


function submitForm(e){

    e.preventDefault();

    const modal = document.querySelector('.modal');
    modal.style.display = 'block';

    setTimeout(function(){

        modal.style.display = 'none';

    },6000);

}




