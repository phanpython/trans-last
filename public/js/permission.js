//Открытие формы фильтрации при нажатии на соответсвующую кнопку
if(document.querySelector('.filter')) {
    let submitFilter = document.querySelector('.filter');
    let blockFilter = document.querySelector('.filter-content');
    let closeFilter = document.querySelector('.close-filter');
    let buttonSearch = document.querySelector('.icon-search');
    let formSearch = document.querySelector('.content-search');
    let inputSearch = document.querySelector('.input-search');

    submitFilter.addEventListener('click', () => {
        blockFilter.classList.toggle('filter-content_active');
    });

    closeFilter.addEventListener('click', () => {
        blockFilter.classList.toggle('filter-content_active');
    });

    //Вешаем слушателя на исконку поиска
    buttonSearch.addEventListener('click', (e) => {
            formSearch.submit();
    });

    setMaskSearch(inputSearch);

    function setMaskSearch(inputSearch) {
        let dateOptions = {
            mask: /^[а-яА-Я0-9 ]*$/,
            lazy: false
        };

        new IMask(inputSearch, dateOptions);
    }
}


//Фиксирование строки таблицы
if(document.querySelector('.table-permission__row')) {
    let checkboxes = document.querySelectorAll('.input-choice-permission');
    let rows = document.querySelectorAll('.table-row');
    let cols = document.querySelectorAll('.col-check');

    //Вешаем лисенеры на ячейку чекбокса
    rows.forEach(e => {
        addListenerForColChoice(e.querySelector('.input-choice'), '.input-choice')
    });

    checkboxes.forEach((e) => {
        e.addEventListener('click', (event) => {
            addListenerAddIdToForms(e, checkboxes)
        });
    });

    cols.forEach((e) => {
        e.addEventListener('click', (event) => {
            addListenerAddIdToForms(e, cols)
        });
    });

    function addListenerAddIdToForms(e, elems) {
        elems.forEach(e => {
            if(e.querySelector('.input-choice')) {
                e = e.querySelector('.input-choice');
            }

            if(e.checked && e !== e) {
                e.checked = false;
            }
        });

        if(e.classList.contains('col-check')) {
            e = e.querySelector('.input-choice');
        }

        let idPermission = e.parentElement.parentElement.querySelector('.row-id').value;
        let inputsProcess = document.querySelectorAll('.row-id-process');
        let inputsIdPermissionForDispatcher = document.querySelectorAll('.permission-status__id');

        //Перетекания айди разрешений в события править, создать на основе, удалить разрешение
        inputsProcess.forEach(input => {
            if(e.checked) {
                input.value = idPermission;
            } else {
                input.value = '';
            }
        })

        //Перетекания айди разрешений в события открыть, приостановить, закрыть разрешение
        inputsIdPermissionForDispatcher.forEach(input => {
            let color = e.parentElement.parentElement.previousElementSibling.value;
            let nameForm = input.nextElementSibling.getAttribute('name');

            if(e.checked) {
                input.value = idPermission;
            } else {
                input.value = '';
                hiddenWindows();
            }

            if(nameForm == 'open-permission' && color == 'green') {
                input.value = '';
            } else if (nameForm == 'pause-permission' && color == 'yellow') {
                input.value = '';
            }else if (nameForm == 'pause-permission' && color == 'blue') {
                input.value = '';
            }
        })
    }
}

//Работа с массивом статусов
if(document.querySelector('.filter-content__statuses')) {
    let inputStatutes = document.querySelector('.filter-content__statuses');
    let inputsStatus = document.querySelectorAll('.filter-content__status-id');
    let button = document.querySelector('.apply-filter');
    let statutes = [];

    inputsStatus.forEach(e => {
       if(e.getAttribute('checked') === 'checked') {
           statutes.push(e.getAttribute('id'));
       }

       e.addEventListener('change', () => {
           if(e.getAttribute('checked') === 'checked') {
               let count = 0;

               inputsStatus.forEach(e => {
                   if(e.getAttribute('checked') === 'checked') {
                       count++;
                   }
               });

               if(count > 1) {
                   e.setAttribute('checked', '');

                   let i = statutes.indexOf(e.getAttribute('id'));
                   statutes.splice(i, 1);
               } else {
                   e.checked = true;
               }
           } else {
               e.setAttribute('checked', 'checked');
               statutes.push(e.getAttribute('id'));
           }
       });
    });

    button.addEventListener('click', (event) => {
        let count = 1;
        statutes.forEach(e => {
            if(count === 1) {
                inputStatutes.value = e;
            } else {
                inputStatutes.value = inputStatutes.value + ' ' + e;
            }

            count++;
        });
    })
}

//Устанавливаем фон строкам таблицы разрешений
if(document.querySelector('.table-permission__background')) {
    let tablePermissionColors = document.querySelectorAll('.table-permission__background');

    tablePermissionColors.forEach(e => {
        let cols = e.nextElementSibling.querySelectorAll('.table-permission__col');

        if(e.value === 'violet') {
            cols.forEach(e => {
                e.classList.add('table-permission__col_violet');
            })
        } else if(e.value === 'beige') {
            cols.forEach(e => {
                e.classList.add('table-permission__col_beige');
            })
        } else if(e.value === 'blue') {
            cols.forEach(e => {
                e.classList.add('table-permission__col_blue');
            })
        } else if(e.value === 'green') {
            cols.forEach(e => {
                e.classList.add('table-permission__col_green');
            })
        } else if(e.value === 'yellow') {
            cols.forEach(e => {
                e.classList.add('table-permission__col_yellow');
            })
        }
    });
}

//Всплытие окна фактического времени изменения статуса разрешения и комментарий для диспетчера
if(document.querySelector('.permission__block-button')) {
    let blocks = document.querySelectorAll('.permission__block-button');

    blocks.forEach(block => {
        let buttonOpenWindow = block.querySelector('.button-content');
        let window = block.querySelector('.permission-status');
        let buttonCancel = block.querySelector('.permission-status__cancel');
        let inputDate = block.querySelector('.permission-status__date');
        let inputTime = block.querySelector('.permission-status__time');

        buttonOpenWindow.addEventListener('click', e => {
            let permissionId = +block.querySelector('.permission-status__id').value;

            if(permissionId > 0) {
                // hiddenWindows();
                toggleWindow(window);
            }
        });

        buttonCancel.addEventListener('click', () => {
            toggleWindow(window);
        });

        function toggleWindow(window) {
            let currentDate = new Date();
            let year = currentDate.getFullYear();
            let month = currentDate.getMonth() + 1;
            let day = currentDate.getDate();
            let hour = currentDate.getHours();
            let minute = currentDate.getMinutes();

            month = setZero(month);
            day = setZero(day);
            hour = setZero(hour);
            minute = setZero(minute);

            inputDate.value = day +  "." + month + "." + year;
            inputTime.value = hour + ':' + minute;

            window.classList.toggle('permission-status_active');
        }

        function setZero(elem) {
            if(+elem < 10) {
                return '0' + elem;
            }

            return elem;
        }
    });
}

function hiddenWindows() {
    let windows = document.querySelectorAll('.permission-status');

    windows.forEach(e => {
        e.classList.remove('permission-status_active')
    });
}




let countRows = document.querySelectorAll('.table-content__row-main').length;

console.log(countRows);

let checkboxesMasking = [];
let checkboxesUnmasking = [];
let checkboxesCheckMasking = [];
let checkboxesCheckUnmasking = [];

for (let i = 1; i < countRows+1; i++) {
    checkboxesMasking[i] = document.querySelector('.masking-'+ i);
    checkboxesUnmasking[i] = document.querySelector('.unmasking-'+ i);
    checkboxesCheckMasking[i] = document.querySelector('.check_masking-'+ i);
    checkboxesCheckUnmasking[i] = document.querySelector('.check_unmasking-'+ i);

    console.log(checkboxesMasking[i]);
 
}

/* let submitMasking = document.querySelector('.submit-masking').length;

submitMasking.addEventListener("click", function() {

    for (let i = 1; i < countRows+1; i++) {

        checkboxesMasking[i].addEventListener('keydown', clickToMasking());
    }
    

  });


function clickToMasking() {
    console.log('yes');

}
 */
    

//window.setInterval( checkTime, 100);