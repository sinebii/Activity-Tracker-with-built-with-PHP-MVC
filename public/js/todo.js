const todo = document.getElementById('todo'),
      todoform = document.getElementById('todoForm'),
      todoBtn = document.getElementById('todoBtn'),
      todoList = document.querySelector('.todo-list')
      
      ;

let d = new Date(),
    yr = d.getFullYear(),
    mth = d.getMonth(),
    dy = d.getDate(),
    hr = d.getHours(),
    mnts = d.getMinutes(),
    scnds = d.getSeconds();


      alltodoEvents();

      function alltodoEvents(){

        document.addEventListener('DOMContentLoaded', initTodo);
        todo.addEventListener('blur', validatefield);
        todoBtn.addEventListener('click',addtolist);
        todoList.addEventListener('click', markTodo);
        




      }


      function initTodo(){

        todoBtn.disabled = true;
        todoBtn.style.cursor = 'auto';
      }

      function validatefield(){

        if(this.value.length < 5){

            todoBtn.disabled = true;
            todoBtn.style.cursor = 'auto';

            todo.classList.add('error');
            let p = document.createElement('p');
            p.textContent = 'Description is too short';
            todoform.appendChild(p);
            setTimeout(function(){

                p.remove();

            },3000)
            
        }else{
            todo.style.borderBottom = '1px solid green';
            todo.classList.remove('error');
            
            todoBtn.disabled = false;
            
            
        }
      }

      function addtolist(e){

        e.preventDefault();
       const error = document.querySelectorAll('error');

       
        //create span for time

        let span = document.createElement('span');
        span.textContent = ' '+ dy + '/'+ eval(mth+1)+ '/'+ yr + '-'+ hr + ':'+mnts;


        //Creating the Mark button
        let markBtn = document.createElement('button');
            markBtn.className = 'mark';
            markBtn.textContent = 'X';

            let li = document.createElement('li');
            li.textContent = todo.value;
            li.appendChild(span);
            li.appendChild(markBtn);
            todoList.appendChild(li);

            let p = document.createElement('p');
            p.textContent = 'Successfully added';
            todoform.appendChild(p);
            todoForm.reset();
               
            setTimeout(function(){

                p.remove();
                

            },2500);

            getTodoInfo(li);
      }


      function markTodo(e){

        if(e.target.classList.contains('mark')){

          e.target.parentElement.remove();

         
        }

      }

      function getTodoInfo(li){

        const todoInfo = {

            todo: li.textContent,
            todoTime: li.firstElementChild.textContent
        }

        console.log(todoInfo);
      }

      



      